<?php
/**
 * Created by PhpStorm.
 * User: keyth
 * Date: 17-10-14
 * Time: 下午4:03
 */
namespace app\index\controller;
use app\common\model\Article;
use app\common\model\Goodtype;
use app\common\model\Member;
use app\common\model\Project;
use think\Controller;
use think\Cookie;
use think\Db;
use think\Request;

class AdminController extends Controller
{
    public function _initialize(){
        $aaa10=NEW Member();
        $cookie=cookie('HZZ_USER_MEM');
        $ipip=Request::instance()->ip();
        if(is_null($cookie)){
            $this->error('未登录，请先登陆！',url('login/index'));
        }
        $aaa10=$aaa10->where('cookie',$cookie)->find();
        if($aaa10){

            if($aaa10->getdata('state')==0){
                $this->error('未登录，请先登陆！',url('login/index'));
            }
            if($ipip!=$aaa10->getdata('visits_ip2')){
                cookie('HZZ_USER',null);
                $this->error('您已在别地登陆！',url('login/index'));
            }
            unset($aaa10);
        }else{
            $this->error('异常操作，请重新登陆后再尝试！',url('login/index'));
        }

    }



    public function index(){
        return $this->fetch();
    }
    public function welcome(){
        return $this->fetch();
    }



    /**
     * 资讯
    **/
    public function article_list(){
        $Article = new Article();
        $articles = $Article->where('state',0)->select();
        $this->assign('articles', $articles);
        return $this->fetch();
    }
    public function article_zhang(){
        $id= Request::instance()->get('id/d');
        if (isset($id) && $id != 0){
            $article=Article::get($id);
            $article->click=$article->click+1;
            $article->save();
        }else{
            return alert('文章不存在或者已被管理员删除！','article_list',5,3);
        }

        $this->assign('article',$article);
        return $this->fetch();
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

    /**
     * 项目
    **/
    public function project_list()
    {
        $Project = new Project();
        $getid=Member::get_id();
        $projects = $Project->where('mid',$getid)->where('state','<',7)->paginate(10);
        $this->assign('projects', $projects);
        return $this->fetch();
    }
    public function project_complete()
    {
        $Project = new Project();
        $getid=Member::get_id();
        $projects = $Project->where('mid',$getid)->where('state=7')->paginate(10);
        Member::integral($getid);
        $this->assign('projects', $projects);
        return $this->fetch();
    }
    public function project_add()
    {
        $Member = new Member();
        $Goodstype= new  Goodtype();
        $memeber = $Member->where('cookie',Cookie('HZZ_USER_MEM'))->select();
        $goodstypes = $Goodstype->select();
        $this->assign('member', $memeber[0]);
        $this->assign('goodstypes', $goodstypes);
        return $this->fetch();
    }
    public function project_add_c()
    {
        $postdaata = Request::instance()->post();
        $Project =new Project();
        $Project->mid =Member::get_id();
        $Project->name = $postdaata['name'];
        $Project->type = $postdaata['type'];
        $Project->price = Goodtype::get($postdaata['type'])->getData('price');
        $Project->describe = $postdaata['describe'];
        $Project->updata_time = time();
        $Project->create_time = time();
        $save= $Project->save();


        if ($save) {
            return alert('项目添加/修改成功', 'project_list', 6, 0);
        }
        return alert('项目添加/修改失败', 'project_add', 5, 0);

    }

    public function project_delect()
    {
        $getdata = Request::instance()->get();
        $Project = new Project();
        $id=Member::get_id();
        $Project->where('mid',$id);
        $Project->where('id', $getdata['id'])->delete();
    }

    /**
     * 发票
    **/
    public function fapiao()
    {
        $id=Member::get_id();
        $Project=NEW Project();
        $fapiaos=Db::name('fapiao')->where('mid',$id)->select();
        $this->assign('fapiaos',$fapiaos);
        $this->assign('Project',$Project);
        return $this->fetch();
    }
    public function fapiao_add()
    {
        $getid=Request::instance()->get('id/d');
        $id=Member::get_id();
        $Project=new Project();
        $projects=$Project->where('is_fapiao',0)->where('state=7')->where('mid',$id)->select();
        if(isset($getid)&&$getid!=0){
            $fapiao=Db::name('fapiao')->where('id',$getid)->select();
            if($fapiao){
                $this->assign('off','off');
                $projects=$Project->where('is_fapiao',$getid)->where('state=7')->where('mid',$id)->select();
                $fapiao=$fapiao[0];
            }else{
                $fapiao['type']="";
                $fapiao['taxnumber']="";
                $fapiao['khh']="";
                $fapiao['khzh']="";
                $fapiao['kpdz']="";
                $fapiao['mobile']="";
                $fapiao['rise']="";
                $fapiao['price']="";
                $fapiao['fpnr']="";
                $fapiao['sjfdz']="";
                $fapiao['sjr']="";
                $fapiao['yzbm']="";
                $fapiao['yldh']="";
                $fapiao['describe']="";
            }
        }else{
            $fapiao['type']="";
            $fapiao['taxnumber']="";
            $fapiao['khh']="";
            $fapiao['khzh']="";
            $fapiao['kpdz']="";
            $fapiao['mobile']="";
            $fapiao['rise']="";
            $fapiao['price']="";
            $fapiao['fpnr']="";
            $fapiao['sjfdz']="";
            $fapiao['sjr']="";
            $fapiao['yzbm']="";
            $fapiao['yldh']="";
            $fapiao['describe']="";
        }
        $this->assign('projects',$projects);
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
        $post['pro_id']=$postdata['pro_id'];
        $post['updata_time']=time();
        $post['create_time']=time();
        if(isset( $postdata['id'])) {
            $post['id'] = $postdata['id'];
            $save=Db::name('fapiao')->field(true)->update($post);
        }else{
            $post['mid']=Member::get_id();
            $project=Project::get($postdata['pro_id']);
            if($project->getData('mid')!=$post['mid']){
                return alert('不是该项目的所有者不能申请发票！','fapiao_add',5,0);}
            if($project->getData('is_fapiao')>0){
                return alert('同一个项目只能申请一个项目！','fapiao_add',5,0);
            }
            $project->is_fapiao=Db::name('fapiao')->getLastInsID();
            $project->save();
            $save=Db::name('fapiao')->field(true)->insert($post);

        }

        if($save){
            return alert('提交成功！','fapiao_add',6,0);
        }
        return alert('提交失败！','fapiao_add',5,0);
    }



}