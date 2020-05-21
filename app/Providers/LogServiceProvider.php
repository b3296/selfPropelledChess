<?php

namespace App\Providers;

use Illuminate\Log\Writer;
use Monolog\Logger as Monolog;
use Illuminate\Support\ServiceProvider;

class LogServiceProvider extends ServiceProvider {
	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register() {
		$channels = $this->app->make( 'config' )->get( 'log', [] );
		foreach ( $channels as $channel => $v ) {
			$this->app->singleton( 'log.' . $channel, function () use ( $channel ) {
				return $this->createLogger( $channel );
			} );
		}

	}

	/**
	 * Create the logger.
	 *
	 * @param $channel
	 *
	 * @return Writer
	 */
	public function createLogger( $channel ) {
		$log = new Writer(
			new Monolog( $channel ), $this->app['events']
		);

		if ( $this->app->hasMonologConfigurator() ) {
			call_user_func( $this->app->getMonologConfigurator(), $log->getMonolog() );
		} else {
			$this->configureHandler( $log );
		}

		return $log;
	}

	/**
	 * Configure the Monolog handlers for the application.
	 *
	 * @param  \Illuminate\Log\Writer $log
	 *
	 * @return void
	 */
	protected function configureHandler( Writer $log ) {
		$this->{'configure' . ucfirst( $this->handler( $log ) ) . 'Handler'}( $log );
	}

	protected function logName( Writer $log ) {
		return $log->getMonolog()->getName();
	}

	/**
	 * Configure the Monolog handlers for the application.
	 *
	 * @param  \Illuminate\Log\Writer $log
	 *
	 * @return void
	 */
	protected function configureSingleHandler( Writer $log ) {
		$name = $this->logName( $log );
		$log->useFiles(
			$this->app->storagePath() . '/logs/' . $name . '.log',
			$this->logLevel( $log )
		);
	}

	/**
	 * Configure the Monolog handlers for the application.
	 *
	 * @param  \Illuminate\Log\Writer $log
	 *
	 * @return void
	 */
	protected function configureDailyHandler( Writer $log ) {
		$name = $this->logName( $log );
		$log->useDailyFiles(
			$this->app->storagePath() . '/logs/' . $name . '/' . $name . '.log', $this->maxFiles( $log ),
			$this->logLevel( $log )
		);
	}

	/**
	 * Configure the Monolog handlers for the application.
	 *
	 * @param  \Illuminate\Log\Writer $log
	 *
	 * @return void
	 */
	protected function configureSyslogHandler( Writer $log ) {
		$log->useSyslog( $this->logName( $log ), $this->logLevel( $log ) );
	}

	/**
	 * Configure the Monolog handlers for the application.
	 *
	 * @param  \Illuminate\Log\Writer $log
	 *
	 * @return void
	 */
	protected function configureErrorlogHandler( Writer $log ) {
		$log->useErrorLog( $this->logLevel( $log ) );
	}

	/**
	 * Get the default log handler.
	 *
	 * @param Writer $log
	 *
	 * @return string
	 */
	protected function handler( Writer $log ) {
		if ( $this->app->bound( 'config' ) ) {
			return $this->app->make( 'config' )->get( 'log.' . $this->logName( $log ) . '.handler', 'single' );
		}

		return 'single';
	}

	/**
	 * Get the log level for the application.
	 *
	 * @param Writer $log
	 *
	 * @return string
	 */
	protected function logLevel( Writer $log ) {
		if ( $this->app->bound( 'config' ) ) {
			return $this->app->make( 'config' )->get( 'log.' . $this->logName( $log ) . '.log_level', 'debug' );
		}

		return 'debug';
	}

	/**
	 * Get the maximum number of log files for the application.
	 *
	 * @param Writer $log
	 *
	 * @return int
	 */
	protected function maxFiles( Writer $log ) {
		if ( $this->app->bound( 'config' ) ) {
			return $this->app->make( 'config' )->get( 'log.' . $this->logName( $log ) . '.log_max_files', 5 );
		}

		return 0;
	}
}

