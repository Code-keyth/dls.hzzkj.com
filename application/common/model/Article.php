<?php
/**
 * Created by PhpStorm.
 * User: FX55
 * Date: 17.10.1
 * Time: 9:37
 */

namespace app\common\model;
use think\Model;

class Article extends Model
{
    public function getCreateTimeAttr($value)
    {
        return date('Y-m-d ', $value);
    }
    public function getUpdataTimeAttr($value)
    {
        return date('Y-m-d ', $value);
    }
    static function article_add_up(){
        $article = new Article();
        $article->title = "";
        $article->title2 = "";
        $article->column="";
        $article->sort = "";
        $article->keywords = "";
        $article->abstract = "";
        $article->author = "admin";
        $article->sources = "本站";
        $article->file = "";
        $article->editorvalue = "";
        return $article;
    }
}