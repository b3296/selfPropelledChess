<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019-03-20
 * Time: 08:53
 */

namespace App\Http\Controllers\SelfPropelledChess;


use App\Http\Controllers\Controller;
use App\Models\Occupation;
use App\Models\OccupationPieces;
use App\Models\Pieces;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PieceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $pieces= Pieces::orderBy('expend')->get();

        return view('chess.piece.index')->with('pieces', $pieces);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // 获取所有职业和种族并将其传递到视图
        $occupation = Occupation::orderBy('type')->get();
        return view('chess.piece.create', ['occupation'=>$occupation]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // 验证 name、email 和 password 字段
        $this->validate($request, [
            'name'=>'required|max:30',
            'nick_name'=>'required|max:30',
            'expend'=>'required|integer',
            'skill_description'=>'required|string|max:1150',
            'attack_speed'=>'required|string|max:20',//攻击速度
            'aggressivity'=>'required|string|max:20',//攻击力
            'attack_distance'=>'required|string|max:20',//攻击距离
            'moving_speed'=>'required|string|max:20',//移动速度
            'skill_enhancement'=>'required|string|max:20',//技能增强
            'magic_recovery'=>'required|string|max:20',//魔法恢复
            'armor'=>'required|string|max:20',//护甲
            'physical_resistance'=>'required|string|max:20',//物理抗性
            'magic_resistance'=>'required|string|max:20',//魔法抗性
            'state_resistance'=>'required|string|max:20',//状态抗性
            'dodge'=>'required|string|max:20',//闪避
            'life_recovery'=>'required|string|max:20',//生命恢复
        ]);
        $file = $request->file('image');
        $url = $this->uploadImage($file);
        $piece_only = [
            'name','nick_name', 'expend', 'skill_description','attack_speed','aggressivity','attack_distance',
            'moving_speed','skill_enhancement','magic_recovery','armor','physical_resistance','magic_resistance',
            'state_resistance','dodge','life_recovery'
        ];
        $pieces = Pieces::create(array_merge($request->only($piece_only),compact('url')));

        $occupation = $request['occupation'];
        // 检查是否某个职业或种族被选中
        if (isset($occupation)) {
            foreach ($occupation as $val) {
                OccupationPieces::create(['occupation_id'=>$val,'piece_id'=>$pieces->id]);
            }
        }
        return redirect()->route('piece.index')
            ->with('flash_message',
                'User successfully added.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $piece = Pieces::find($id);
        return view('chess.piece.show')->with('piece',$piece);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $piece = Pieces::findOrFail($id); // 通过给定id获取用户
        $occupation = Occupation::orderBy('type')->get();

        return view('chess.piece.edit', compact('piece', 'occupation'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $pieces = Pieces::findOrFail($id); // 通过id获取给定角色

        // 验证 name, email 和 password 字段
        $this->validate($request, [
            'name'=>'required|max:30',
            'nick_name'=>'required|max:30',
            'expend'=>'required|integer',
            'skill_description'=>'required|string|max:150',
            'attack_speed'=>'required|string|max:20',//攻击速度
            'aggressivity'=>'required|string|max:20',//攻击力
            'attack_distance'=>'required|string|max:20',//攻击距离
            'moving_speed'=>'required|string|max:20',//移动速度
            'skill_enhancement'=>'required|string|max:20',//技能增强
            'magic_recovery'=>'required|string|max:20',//魔法恢复
            'armor'=>'required|string|max:20',//护甲
            'physical_resistance'=>'required|string|max:20',//物理抗性
            'magic_resistance'=>'required|string|max:20',//魔法抗性
            'state_resistance'=>'required|string|max:20',//状态抗性
            'dodge'=>'required|string|max:20',//闪避
            'life_recovery'=>'required|string|max:20',//生命恢复
        ]);
        $piece_only = [
            'name','nick_name', 'expend', 'skill_description','attack_speed','aggressivity','attack_distance',
            'moving_speed','skill_enhancement','magic_recovery','armor','physical_resistance','magic_resistance',
            'state_resistance','dodge','life_recovery'
        ];
        $input = $request->only($piece_only);
        $file = $request->file('image');
        if(!is_null($file)){
            $input['url'] = $this->uploadImage($file);
        }
        $occupation = $request['occupation'];
        $pieces->fill($input)->save();
        if (isset($occupation)) {
            OccupationPieces::where('piece_id',$pieces->id)->whereNotIn('occupation_id',$occupation)->delete();
            foreach ($occupation as $val) {
                $is = OccupationPieces::where('piece_id',$pieces->id)->where('occupation_id',$val)->first();
                if(!$is){
                    OccupationPieces::create(['occupation_id'=>$val,'piece_id'=>$pieces->id]);
                }
            }
        }else{
            OccupationPieces::where('piece_id',$pieces->id)->delete();
        }
        return redirect()->route('piece.index')
            ->with('flash_message',
                'User successfully edited.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // 通过给定id获取并删除用户
        $piece = Pieces::findOrFail($id);
        $piece->delete();

        return redirect()->route('piece.index')
            ->with('flash_message',
                'User successfully deleted.');
    }
    //上传图片
    private function uploadImage( $file ) {
        if ( $file->isValid() ) {
            // 获取文件相关信息
            $originalName = $file->getClientOriginalName(); // 文件原名
            $ext          = $file->getClientOriginalExtension();     // 扩展名
            $realPath     = $file->getRealPath();   //临时文件的绝对路径
            $type         = $file->getClientMimeType();     // image/jpeg

            // 上传文件
            $filename = 'piece/'.date( 'Y-m-d-H-i-s' ) . '-' . uniqid() . '.' . $ext;
            // 使用我们新建的uploads本地存储空间（目录）
            $disk = 'uploads';

            $bool = Storage::disk( $disk )->put( $filename, file_get_contents( $realPath ) );

            return $disk . '/' . $filename;
        }
    }
}