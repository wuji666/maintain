<?php
/**
 * Created by PhpStorm.
 * User: storn
 * Date: 2019/5/27
 * Time: 15:57
 */

namespace app\admins\controller;

use think\Controller;
use Util\SysDb;

class Adhibition extends Base
{
    public function index()
    {
        $lists = 1;
        $this->view->lists = $lists;
        return $this->fetch();
    }
}