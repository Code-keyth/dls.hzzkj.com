<?php
namespace app\index\controller;

use app\common\model\Article;
use app\common\model\Article_type;
use app\common\model\Liuyan;
use app\common\model\Member;
use think\console\command\make\Model;
use think\Controller;
use think\Request;

class IndexController extends Controller
{
    public function index(){
        return $this->fetch();
    }
    public function head(){
        return $this->fetch();
    }
    public function footer(){
        return $this->fetch();
    }
    public function Agencyconsultation(){
        return $this->fetch();
    }

    public function Agencypolicy(){
        return $this->fetch();
    }
    public function Contactus(){
        return $this->fetch();
    }
    public function CrossborderTrade(){
        return $this->fetch();
    }

    public function Customized(){
        return $this->fetch();
    }
    public function DataopenAPI(){
        return $this->fetch();
    }
    public function EnterpriseCloud(){
        $id=Request::instance()->get('id/d');
        $type4=Article_type::get(4);
        $type5=Article_type::get(5);
        if(!$id){
            $id=4;
        }
        $Article=new Article();
        $news=$Article->where('type',$id)->paginate(8);
        if (!$news->isEmpty()){
            $this->assign('news',$news);
            $this->assign('type4',$type4);
            $this->assign('type5',$type5);
            $this->assign('typeid',$id);
            return $this->fetch();}
        else{
            return alert('非法操作!','enterprisecloud',5);
        }
    }
    public function ITservice(){
        return $this->fetch();
    }
    public function onlineshop(){
        return $this->fetch();
    }
    public function proxypattern(){
        return $this->fetch();
    }
    public function SEO(){
        return $this->fetch();
    }
    public function Serviceplatform(){
        return $this->fetch();
    }
    public function smallprogram(){
    return $this->fetch();
    }
    public function Station(){
        return $this->fetch();
    }
    public function Websitecase(){
        return $this->fetch();
    }
    public function WeChatdistribution(){
    return $this->fetch();
    }
    public function WeChatmarketing(){
        return $this->fetch();
    }
    public function Wordofmouth(){
    return $this->fetch();
    }
    public function News(){
        $id=Request::instance()->get('id/d');
        if(!$id){
            $id=1;
        }
        $Article=new Article();
        $news=$Article->where('type',$id)->paginate(10,false,['query'=>['id'=>$id,],]);
        $this->assign('news',$news);
        return $this->fetch();
    }


    /**
     * 直接申请成为代理商
     **/
    public function shenhe_dls(){
        $postdata=Request::instance()->post();
        $Member=new Member();
        $Member->username = $postdata['username'];
        $Member->mobile = $postdata['mobile'];
        $Member->email = $postdata['email'];
        $Member->city = $postdata['province'] . '-' . $postdata['city'] . '-' . $postdata['district'];
        $Member->annotate = $postdata['annotate'];
        $Member->auditing = 1;
        $Member->updata_time = time();
        $Member->create_time = time();
        $Member->save();
        return alert('我们已经收到您的s申请,请耐心等待!谢谢您的留言!','agencyconsultation',6,0);
    }
    public function Newscontent(){
        $id= Request::instance()->get('id/d');
        $article=Article::get($id);
        $Article=new Article();
        $articles=$Article->order('click desc')->limit(6)->select();
        $this->assign('article',$article);
        $this->assign('articles',$articles);
        return $this->fetch();
    }
    public function Liuyan(){
        $Liuyan=new Liuyan();
        $postdata=Request::instance()->post();
        $Liuyan->name=$postdata['name'];
        $Liuyan->mobile=$postdata['mobile'];
        $Liuyan->content=$postdata['content'];
        $Liuyan->save();
        $post['updata_time']=time();
        $post['create_time']=time();
        return alert('我们已经收到您的留言,请耐心等待!谢谢您的留言!','agencyconsultation',6,0);
    }



}
