<?php
namespace app\admin\controller;
use app\common\model\Admin;
use app\common\model\Article;
use app\common\model\Config;
use app\common\model\Goodtype;
use app\common\model\Member;
use app\common\model\Project;
use think\Controller;
use think\Db;
use think\Log;
use think\Request;

class IndexController extends Controller
{
    public function _initialize()
    {
        $aaa10 = NEW Admin();
        $cookie = cookie('HZZ_USER');
        $ipip = Request::instance()->ip();

        if (is_null($cookie)) {
            $this->error('未登录，请先登陆！', url('login/index'));
        }
        $aaa10 = $aaa10->where('cookie', $cookie)->find();
        if ($aaa10) {
            if ($aaa10->getdata('state') == 0) {
                $this->error('未登录，请先登陆！', url('login/index'));
            }
            if ($ipip != $aaa10->getdata('visits_ip2')) {
                cookie('HZZ_USER', null);
                $this->error('您已在别地登陆！', url('login/index'));
            }
            unset($aaa10);
        } else {
            $this->error('异常操作，请重新登陆后再尝试！', url('login/index'));}
    }

    public function index()
    {
        $Admin=NEW Admin();
        $admin_info=$Admin->where('cookie',cookie('HZZ_USER'))->find();
        if($admin_info->getdata('state')==0){
            return alert('未登录，请先登陆！',url('login/index'),5,3);
        }
        $Config=new Config();
        $configs=$Config->column('value');
        $this->assign('config',$configs);

        $this->assign('admin',$admin_info);
        return $this->fetch();
    }

    public function welcome()
    {

        $admin = Admin::get(1);
        $Member = new Member();
        $Project = new Project();
        $info['member_number'] = $Member->count();
        $info['member_dls_number'] = $Member->where('level', '>', 0)->count();
        $info['project_number'] = $Project->count();
        $info['project_ing_number'] = $Project->where('state', '<', 7)->count();
        $info['new_member_number'] = $Member->where('create_time', '>', time() - 2592000)->count();
        $info['member_dls_sh_number'] = $Member->where('auditing', 1)->count();
        $info['fapiao_number'] = Db::name('fapiao')->count();
        $this->assign('admin', $admin);
        $this->assign('info', $info);
        return $this->fetch();
    }

    /**
     * 资讯
     **/
    public function article_list()
    {
        $Article = new Article();
        $articles = $Article->select();
        $this->assign('articles', $articles);
        return $this->fetch();
    }
    public function article_add()
    {
        $id = Request::instance()->get('id/d');
        $Article = new Article();
        if (!is_null($id)) {
            $article = $Article->where('id', $id)->select();
            if (!$article) {
                $article=Article::article_add_up();
                $article->type='';
            } else {
                $article = $article[0];
                $this->assign('off','off');
            }
        } else {
            $article=Article::article_add_up();
            $article->type='';
        }
        $this->assign('article', $article);
        return $this->fetch();
    }

    public function article_state()
    {
        $getdata = Request::instance()->get();
        $Article = new Article();
        Log::write('管理员['.Admin::get_id().']将文章[id='.$Article->id.']的状态变成===>'.$getdata['state'],'art_add');
        $Article->where('id', $getdata['id'])->setField('state', $getdata['state']);
    }

    public function article_delect()
    {
        $getdata = Request::instance()->get();
        $Article = new Article();
        $Article->where('id', $getdata['id'])->delete();}

    public function article_c()
    {
        $postdata = Request::instance()->post();
        if(isset( $postdata['id'])) {
            $Article =Article::get($postdata['id']);
        }else{
            $Article = NEW Article();
        }
        $Article->title = $postdata['articletitle'];
        $Article->title2 = $postdata['articletitle2'];
        #$Article->column=$postdata['articlecolumn'];
        $Article->type = $postdata['articletype'];
        $Article->sort = $postdata['articlesort'];
        $Article->keywords = $postdata['keywords'];
        $Article->abstract = $postdata['abstract'];
        $Article->author = $postdata['author'];
        $Article->sources = $postdata['sources'];
        $Article->file = $postdata['file'];
        $Article->editorvalue = $postdata['editorValue'];
        $Article->updata_time = time();
        $Article->create_time = time();
        $a = $Article->save();
        if ($a) {
            Log::write('管理员['.Admin::get_id().']发布/修改了文章[id='.$Article->id,'art_add');
            return alert('资讯发布/修改成功', 'article_list', 6, 0);
        } else {
            return alert("发布失败<br/>原因:" . $Article->getError(), 'article_list', 5, 0);
        }
    }

    /**
     * 会员4
     **/
    public function member_list()
    {
        $getoff = Request::instance()->get('off');
        if ($getoff == 'off') {
            $this->assign('off', 'off');
        }
        $Member = new Member();

        $members = $Member->where('level=0')->order('id desc')->select();
        $this->assign('members', $members);
        return $this->fetch();
    }

    public function member_list_dls()
    {
        $Member = new Member();
        $members_dl = $Member->where('level>0')->select();
        $this->assign('members_dl', $members_dl);
        return $this->fetch();
    }

    public function member_list_dls_sh()
    {
        $Member = new Member();
        $members_sh = $Member->where('auditing>0')->select();
        $this->assign('members_sh', $members_sh);
        return $this->fetch();
    }

    public function member_add()
    {
        $id = Request::instance()->get('id/d');
        if (isset($id) && $id != 0) {
            $Member = Member::get($id);
            if (isset($Member)) {
                $a = explode('-', $Member->getdata('city'));
                $Member->city = $a[0];
                $Member->province = $a[1];
                $Member->district = $a[2];
                $this->assign('off', 'off');
            } else {
                $Member=Member::member_add_up();
            }
        } else {
            $Member=Member::member_add_up();
        }
        $this->assign('member', $Member);
        return $this->fetch();
    }

    public function member_add_c()
    {
        $postdata = Request::instance()->post();
        if (!empty($postdata['id'])) {
            $id = $postdata['id'];
            $Member = Member::get($id);
        } else {
            $Member = NEW Member();
        }
        $Member->username = $postdata['username'];
        $Member->mobile = $postdata['mobile'];
        $Member->email = $postdata['email'];
        $Member->city = $postdata['province'] . '-' . $postdata['city'] . '-' . $postdata['district'];
        $Member->annotate = $postdata['annotate'];
        $Member->street = $postdata['street'];
        $Member->sex = $postdata['sex'];
        $Member->updata_time = time();
        $Member->create_time = time();
        $save = $Member->save();
        if ($save) {
            Log::write('管理员['.Admin::get_id().']在后台添加/修改了会员[id='.$Member->id.']的信息！','mem_log');
            return alert('会员资料添加/修改成功', 'member_add', 6, 0);
        } else {
            return alert('会员资料添加/修改失败', 'member_add', 5, 0);
        }
    }

    public function member_add_dls()
    {
        $members = Member::all();
        $this->assign('members', $members);
        return $this->fetch();
    }

    public function member_add_dls_c()
    {
        $post = Request::instance()->post();
        $Member = NEW Member();
        $id = $post['id'];
        $level = $post['level'];
        $save = $Member->where('id', $id)->setField('level', $level);
        if ($save) {
            Log::write('管理员['.Admin::get_id().']在后台给会员[id='.$id.']升级为[---'.$level.'级---]！','mem_log');
            return alert('添加/修改代理商成功！', 'member_add_dls', 6, 0);
        }
        return alert('添加/修改代理商失败！', 'member_add_dls', 5, 0);
    }

    public function member_level()
    {
        return $this->fetch();
    }
    public function member_up_level()
    {
        $data=Request::instance()->get();

       if(count($data)==2){
            Log::write('管理员['.Admin::get_id().']在后台通过了会员[id='.$data['id'].']升级为[level='.$data['level'].']的去请求！','mem_log');
            $save=Member::update(['id'=>$data['id'],'level'=>$data['level'],'auditing'=>0]);
        }else{
            Log::write('管理员['.Admin::get_id().']在后台拒绝了会员[id='.$data['id'].']升级的请求！','mem_log');
            $save=Member::update(['id'=>$data['id'],'auditing'=>0]);
        }
        if($save)
            return true;
        return false;
    }


    public function member_show()
    {
        return $this->fetch();
    }

    public function member_password()
    {
        $getid = Request::instance()->get('id/d');
        $member = new Member();
        if (isset($getid) && $getid != 0) {
            $member = Member::get($getid);
            if (isset($member)) {
                ;
            } else {
                $this->assign('off', 'off');
                return alert('非法操作！', 'member_list', 5, 0);
            }
        } else {
            $this->assign('off', 'off');
            return alert('非法操作！', 'member_list', 5, 0);
        }
        $this->assign('member', $member);
        return $this->fetch();

    }

    public function member_up_pw()
    {
        $data = Request::instance()->post();
        $id = Request::instance()->get();
        if (isset($id) && $id != 0) {
            $Memeber = Member::get($id);
            if (isset($Memeber)) {
                $Memeber->passwd = $data['newpassword'];
            } else {

                return alert('非法操作！', 'member_list', 5, 0);
            }
            $save = $Memeber->save();
        } else {
            return alert('非法操作！', 'member_list', 5, 0);
        }
        if ($save) {
            return alert('密码强制修改成功！', 'member_list.html?off=off', 6, 0);
        }
        return alert('密码强制修改失败！', 'member_list?off=off', 6, 0);
    }

    public function member_delect()
    {
        $getdata = Request::instance()->get();
        $Member = new Member();
        $Member->where('id', $getdata['id'])->delete();
    }








    /**
     * 产品
     **/
    public function product_brand()
    {
        $Goodtypes = Goodtype::all();
        $this->assign('types', $Goodtypes);
        return $this->fetch();
    }
    public function product_add()
    {
        $getid = Request::instance()->get('id/d');

        if (isset($getid) && $getid != 0) {
            $goodtype = Goodtype::get($getid);
            if ($goodtype) {
                $this->assign('off', 'off');
            } else {
                $goodtype= Goodtype::type_add_up();
                $goodtype->name = '';
            }
        } else {
            $goodtype= Goodtype::type_add_up();
            $goodtype->name = '';
        }

        $this->assign('goodtype', $goodtype);
        return $this->fetch();
    }

    public function product_add_c()
    {
        $postdata = Request::instance()->post();
        $getid = Request::instance()->post('id/d');
        $Goodtype = NEW Goodtype();

        $Goodtype->name = $postdata['name'];
        $Goodtype->describe = $postdata['describe'];
        $Goodtype->price = $postdata['price'];
        $Goodtype->id=$getid;
        $aa=false;
        if (isset($getid) && $getid != 0){
           $aa=true;
        }

        $save = $Goodtype->isUpdate($aa)->save();
        if ($save) {
            return alert('产品分类添加/修改成功！', 'product_brand', 6, 0);
        } else {
            return alert('产品分类添加/修改失败！', 'product_brand', 5, 0);
        }
    }

    public function product_delect()
    {
        $id = Request::instance()->get('id/d');
        $Goodtype = new Goodtype();
        $Goodtype->where('id', $id)->delete();

    }

    /**
     * 项目
     **/
    public function project_add()
    {
        $getid = Request::instance()->get('id/d');
        $Member = new Member();
        $Project = NEW Project();
        $Goodstype= new  Goodtype();
        $Admin= NEW Admin();
        $admins = $Admin->where('id>1')->select();
        $memebers_dls = $Member->select();
        $goodstypes = $Goodstype->select();
        if (isset($getid) && $getid != 0) {
            $project_member = $Project->where('id', $getid)->select();
            if ($project_member) {
                $project = $project_member;
                $project = $project[0];
                $this->assign('off','off');
            } else {
                $project =Project::pro_add_up();
                $project ->name = "";
                $project ->type = "";
            }
        } else {
            $project =Project::pro_add_up();
            $project ->name = "";
            $project ->type = "";
        }
        $this->assign('project', $project);
        $this->assign('getid', $getid);
        $this->assign('members_dls', $memebers_dls);
        $this->assign('admins', $admins);
        $this->assign('goodstypes', $goodstypes);
        return $this->fetch();
    }

    public function project_add_c()
    {
        $postdaata = Request::instance()->post();
        if(!isset( $postdata['id'])) {
            $Project =Project::get($postdaata['id']);
        }else{
            $Project =new Project();
        }
        $Project->name = $postdaata['name'];
        $Project->type = $postdaata['type'];
        $Project->mid = $postdaata['mid'];
        $Project->price = $postdaata['price'];
        $Project->describe = $postdaata['describe'];
        $Project->updata_time = time();
        $Project->create_time = time();
        $Project->start_time = $postdaata['start_time'];
        $Project->end_time = $postdaata['end_time'];
        $save= $Project->save();
        if ($save) {
            return alert('项目添加/修改成功', 'project_list', 6, 0);
        }
        return alert('项目添加/修改失败', 'project_add', 5, 0);
    }

    public function project_list()
    {
        $Project = new Project();
        $getid = Request::instance()->get('id/d');
        $projects = $Project->where('state<7')->paginate(10);
        $Member = new Member();
        $memebers_dls = $Member->select();
        if (isset($getid) && $getid != 0) {
            $project_member = $Project->where('mid', $getid)->where('state<7')->paginate(10);
            if (isset($project_member)) {
                $projects = $project_member;
            }
        }
        $this->assign('members_dls', $memebers_dls);
        $this->assign('projects', $projects);
        $this->assign('getid', $getid);
        return $this->fetch();
    }

    public function project_delect()
    {
        $getdata = Request::instance()->get();
        $Project = new Project();
        $Project->where('id', $getdata['id'])->delete();
    }
    public function project_state()
    {
        $id=Request::instance()->get('id/d');
        $state=Request::instance()->get('state/d');
        $Project = new Project();
        $state=$state+1;
        $Project->where('id', $id)->setField('state',$state);
        $state1=$state-1;
        Log::write('管理员['.Admin::get_id().']把项目<'.$id.'>的状态由[---'.$state1.'---]变成了[---'.$state.'---]','pro_start');
    }

    public function project_complete()
    {
        $Project = new Project();
        $projects = $Project->where('state=7')->select();
        $ids=$Project->where('state=7')->group('mid')->column('mid');
        foreach ($ids as $id){
            Member::integral($id);
        }
        $this->assign('projects', $projects);
        return $this->fetch();
    }


    /**
     * 发票
     **/

    public function fapiao()
    {
        $fapiaos=Db::name('fapiao')->select();
        $this->assign('fapiaos',$fapiaos);
        return $this->fetch();
    }
    public function fapiao_add()
    {
        $getid=Request::instance()->get('id/d');
        if(isset($getid)&&$getid!=0){
            $fapiao=Db::name('fapiao')->where('id',$getid)->select();
            if($fapiao){
                $this->assign('off','off');
                $fapiao=$fapiao[0];
            }else{
                $fapiao=Member::member_fapiao();
            }
        }else{
            $fapiao=Member::member_fapiao();
        }
        $this->assign('fapiao',$fapiao);
        return $this->fetch();
    }
    public function fapiao_add_c()
    {
        $postdata=Request::instance()->post();
        $post['type']=$postdata['type'];
        $post['taxnumber']=$postdata['taxnumber'];
        $post['khh']=$postdata['khh'];
        $post['khzh']=$postdata['khzh'];
        $post['kpdz']=$postdata['kpdz'];
        $post['mobile']=$postdata['mobile'];
        $post['rise']=$postdata['rise'];
        $post['price']=$postdata['price'];
        $post['fpnr']=$postdata['fpnr'];
        $post['sjfdz']=$postdata['sjfdz'];
        $post['sjr']=$postdata['sjr'];
        $post['yzbm']=$postdata['yzbm'];
        $post['yldh']=$postdata['yldh'];
        $post['describe']=$postdata['describe'];
        $post['updata_time']=time();
        $post['create_time']=time();
        if(!isset( $postdata['id'])) {
            $post['id'] = $postdata['id'];
            $save=Db::name('fapiao')->field(true)->update($post);
        }else{
            $save=Db::name('fapiao')->field(true)->insert($post);
        }
        if($save){
            return alert('提交成功！','fapiao_add',6,0);
        }
        return alert('提交失败！','fapiao_add',5,0);
    }

    public function fapiao_delect()
    {
        $getdata = Request::instance()->get();
        $save=Db::name('fapiao')->where('id', $getdata['id'])->delete();
        if($save){
            return true;
        }else{
            return false;
        }
    }
    public function fapiao_state()
    {
        $getdata = Request::instance()->get();
        $save=Db::name('fapiao')->where('id', $getdata['id'])->update(['state'=>'1']);
        if($save){
            return true;
        }else{
            return false;
        }
    }




}
