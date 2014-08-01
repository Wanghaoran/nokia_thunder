<?php
// 本类由系统自动生成，仅供测试用途
class IndexAction extends Action {
    public function index(){

        //接收参数
        $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
        //XML转对象
        $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
        //发送方帐号（一个OpenID）
        $fromUsername = $postObj->FromUserName;
        //开发者微信号
        $toUsername = $postObj->ToUserName;
        //文本消息内容
        $keyword = trim($postObj->Content);
        $MsgType = strval($postObj -> MsgType);
        //消息类型
        $Event = $postObj->Event;
        //返回消息模版
        $textTpl = "<xml>
                    <ToUserName><![CDATA[%s]]></ToUserName>
                    <FromUserName><![CDATA[%s]]></FromUserName>
                    <CreateTime>%s</CreateTime>
                    <MsgType><![CDATA[%s]]></MsgType>
                    <Content><![CDATA[%s]]></Content>
                    <FuncFlag>0</FuncFlag>
                    </xml>";

        //返回图文消息模版 - 一条消息
        $textNews_one = "<xml>
                     <ToUserName><![CDATA[%s]]></ToUserName>
                     <FromUserName><![CDATA[%s]]></FromUserName>
                     <CreateTime>%s</CreateTime>
                     <MsgType><![CDATA[%s]]></MsgType>
                     <ArticleCount>%s</ArticleCount>
                     <Articles>
                     <item>
                     <Title><![CDATA[%s]]></Title>
                     <Description><![CDATA[%s]]></Description>
                     <PicUrl><![CDATA[%s]]></PicUrl>
                     <Url><![CDATA[%s]]></Url>
                     </item>
                     </Articles>
                     </xml>";

        $time = time();


        if($MsgType == 'image'){

            $Status = M('Status');
            $openid = strval($fromUsername);
            $where = array();
            $where['openid'] = $openid;
            $where['status'] = 1;
            //查询是否标记
            if($result = $Status -> field('id') -> where($where) -> find()){
                $msgType = 'text';
                $contentStr = '感谢您参与活动，恭喜您已成功获得<a href="http://taoquan.taobao.com/coupon/unify_apply.htm?sellerId=1115574360&activityId=130552231">诺基亚天猫专卖店Lumia 630双卡双待购机50元优惠券</a>和<a href="http://taoquan.taobao.com/coupon/unify_apply.htm?sellerId=202226971&activityId=130482478">诺基亚XL购机50元优惠券</a>，立即领取吧！（领取方式：请您点击优惠券并根据提示复制链接，再粘贴到手机浏览器中打开即可使用）';
                $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);

                //删除标记
                $Status -> delete($result['id']);

                //发送消息
                echo $resultStr;
                exit();
            }


            $num = file_get_contents('./num.text');
            $num ++;
            file_put_contents('./num.text', $num);

            $msgType = 'text';
            $contentStr = '感谢您参与活动，恭喜您已成功获得<a href="http://taoquan.taobao.com/coupon/unify_apply.htm?sellerId=1115574360&activityId=123562012">诺基亚天猫专卖店Ｌｕｍｉａ６３０双卡双待购机５０元优惠券</a>，立刻领取吧！（领取方式：请您点击优惠券并根据提示复制链接，再粘贴到手机浏览器中打开即可使用）';
            $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
            echo $resultStr;
            exit();

        }

        //有关键词的是消息推送
        if(!empty($keyword)){
            $keyword = strtolower($keyword);

            switch($keyword){
                case '1':
                    $msgType = 'text';
                    $contentStr = "四大系列，精彩各不相同！最想了解哪个呢？a. Lumia非凡系列 b. 诺基亚Asha新趣系列 c. 诺基亚X系列 d. 实用经典系列 e. 输入产品型号直接查看产品信息（回复a,b,c,d,e即可）";
                    $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                break;

                case 'a':
                    $Articles = array(
                        array(
                            'title' => '诺基亚LUMIA638 4G',
                            'description' => '',
                            'picurl' => 'http:/42.121.116.205/nokia_wechat/Public/images/1.jpg',
                            'url' => 'http://mp.weixin.qq.com/s?__biz=MjM5Mjk2MjA0MA==&mid=200806259&idx=1&sn=bf0a271c79ed7ae0a84a0b2ce091d356#rd',
                        ),
                        array(
                            'title' => '参数配置',
                            'description' => '',
                            'picurl' => 'http:/42.121.116.205/nokia_wechat/Public/images/2.jpg',
                            'url' => 'http://mp.weixin.qq.com/s?__biz=MjM5Mjk2MjA0MA==&mid=200806259&idx=2&sn=373821cfe9a7071dc8afa2d06aa3cf49#rd',
                        ),
                    );
                    $this -> responseNews($toUsername, $fromUsername, $Articles);
                break;
                case 'b':
                    $Articles = array(
                        array(
                            'title' => '诺基亚503 小身材 大智慧',
                            'description' => '',
                            'picurl' => 'http:/42.121.116.205/nokia_wechat/Public/images/3.jpg',
                            'url' => 'http://mp.weixin.qq.com/s?__biz=MjM5Mjk2MjA0MA==&mid=200806717&idx=1&sn=394403cda220c3a21422f83bc5a7211e#rd',
                        ),
                        array(
                            'title' => '参数配置',
                            'description' => '',
                            'picurl' => 'http:/42.121.116.205/nokia_wechat/Public/images/4.jpg',
                            'url' => 'http://mp.weixin.qq.com/s?__biz=MjM5Mjk2MjA0MA==&mid=200806717&idx=2&sn=40e03a269aa412720896d2c4b9c8a6b3#rd',
                        ),
                    );
                    $this -> responseNews($toUsername, $fromUsername, $Articles);
                break;
                case 'c':
                    $Articles = array(
                        array(
                            'title' => '诺基亚XL 4G 跨界而来',
                            'description' => '',
                            'picurl' => 'http:/42.121.116.205/nokia_wechat/Public/images/5.jpg',
                            'url' => 'http://mp.weixin.qq.com/s?__biz=MjM5Mjk2MjA0MA==&mid=200806623&idx=1&sn=2880e20ca78be25cbb8ac88daef24447#rd',
                        ),
                        array(
                            'title' => '参数配置',
                            'description' => '',
                            'picurl' => 'http:/42.121.116.205/nokia_wechat/Public/images/6.jpg',
                            'url' => 'http://mp.weixin.qq.com/s?__biz=MjM5Mjk2MjA0MA==&mid=200806623&idx=2&sn=535893af28f29b92eb05699a174d61cd#rd',
                        ),
                    );
                    $this -> responseNews($toUsername, $fromUsername, $Articles);
                break;

                case 'd':
                    $Articles = array(
                        array(
                            'title' => '诺基亚225 双卡双待',
                            'description' => '',
                            'picurl' => 'http:/42.121.116.205/nokia_wechat/Public/images/7.jpg',
                            'url' => 'http://mp.weixin.qq.com/s?__biz=MjM5Mjk2MjA0MA==&mid=200806722&idx=1&sn=18401294f13527b96b11bf9466901236#rd',
                        ),
                        array(
                            'title' => '参数配置',
                            'description' => '',
                            'picurl' => 'http:/42.121.116.205/nokia_wechat/Public/images/8.jpg',
                            'url' => 'http://mp.weixin.qq.com/s?__biz=MjM5Mjk2MjA0MA==&mid=200806722&idx=2&sn=af1039cbd1ac640032389fd3d3b05c97#rd',
                        ),
                    );
                    $this -> responseNews($toUsername, $fromUsername, $Articles);
                break;

                case 'e':
                    $content = "小诺为大家整理了目前热门畅销机型，直接输入以下产品型号即可查看产品信息\n●LUMIA 638\n●LUMIA1520\n●诺基亚X\n●诺基亚XL4G\n●诺基亚503\n●诺基亚1080\n●诺基亚225\n●诺基亚630";
                    $this -> responseText($toUsername, $fromUsername, $content);
                    break;

                case '2':
                    $msgType = 'news';
                    $ArticleCount = 1;
                    $Title = '本周LumiaAPP精彩回顾';
                    $Description = '精彩TOP3：1.Glean；２．暴走日报；3.YY';
                    $PicUrl = 'http://mmbiz.qpic.cn/mmbiz/3RdqPmGN9EvTtZspRUpibKHuJFnIfyFsts5GHdLreFdCefC3OqibzvGibsfBNCPNs3fDicfY2xyBSO4tzjwoByiaibHg/0';
                    $Url = 'http://mp.weixin.qq.com/s?__biz=MjM5Mjk2MjA0MA==&mid=200348499&idx=1&sn=493eca6c99104ed08f171d670e544871#rd';
                    $resultStr = sprintf($textNews_one, $fromUsername, $toUsername, $time, $msgType, $ArticleCount, $Title, $Description, $PicUrl, $Url);
                break;

                case '3':
                    $msgType = 'news';
                    $ArticleCount = 1;
                    $Title = '诺基亚XL跨界合作4大APP游戏，给你意想不到的精彩！';
                    $Description = '参与有趣的跨界游戏，均有诺基亚XL作为大奖送出！【详细信息请点击查看】';
                    $PicUrl = 'http://mmbiz.qpic.cn/mmbiz/3RdqPmGN9Eua4g3CDXmyicib1eDpuiasFOc0qc66OkA0Ix4LzCC3KqUbNPe9sJXDibeua6XH63eIcq2oXzMYbZyoNA/0';
                    $Url = 'http://mp.weixin.qq.com/s?__biz=MjM5Mjk2MjA0MA==&mid=200575341&idx=1&sn=4b91f2dd3f351e3ea7194ac4385c10fc#rd';
                    $resultStr = sprintf($textNews_one, $fromUsername, $toUsername, $time, $msgType, $ArticleCount, $Title, $Description, $PicUrl, $Url);
                    break;

                case '638':
                case 'lumia638':
                    $Articles = array(
                        array(
                            'title' => '诺基亚LUMIA638 4G',
                            'description' => '',
                            'picurl' => 'http:/42.121.116.205/nokia_wechat/Public/images/1.jpg',
                            'url' => 'http://mp.weixin.qq.com/s?__biz=MjM5Mjk2MjA0MA==&mid=200806259&idx=1&sn=bf0a271c79ed7ae0a84a0b2ce091d356#rd',
                        ),
                        array(
                            'title' => '参数配置',
                            'description' => '',
                            'picurl' => 'http:/42.121.116.205/nokia_wechat/Public/images/2.jpg',
                            'url' => 'http://mp.weixin.qq.com/s?__biz=MjM5Mjk2MjA0MA==&mid=200806259&idx=2&sn=373821cfe9a7071dc8afa2d06aa3cf49#rd',
                        ),
                    );
                    $this -> responseNews($toUsername, $fromUsername, $Articles);
                    break;

                case '1520':
                case 'lumia1520':
                    $Articles = array(
                        array(
                            'title' => '诺基亚LUMIA1520 大有可言',
                            'description' => '',
                            'picurl' => 'http:/42.121.116.205/nokia_wechat/Public/images/9.jpg',
                            'url' => 'http://mp.weixin.qq.com/s?__biz=MjM5Mjk2MjA0MA==&mid=200810263&idx=1&sn=2653c9960cfd08da4dcfe3522913c06b#rd',
                        ),
                        array(
                            'title' => '参数配置',
                            'description' => '',
                            'picurl' => 'http:/42.121.116.205/nokia_wechat/Public/images/10.jpg',
                            'url' => 'http://mp.weixin.qq.com/s?__biz=MjM5Mjk2MjA0MA==&mid=200810263&idx=2&sn=038d938a542c09d2518379a8f416c533#rd',
                        ),
                    );
                    $this -> responseNews($toUsername, $fromUsername, $Articles);
                    break;

                case '我是帮友':
                    $msgType = 'text';
                    $contentStr = "活动还未上线，敬请期待。。。";
                    $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                    break;

                default:
                    $msgType = 'text';
                    $contentStr = "感谢你关注诺基亚官方微信~想获得你感兴趣的相关诺基亚讯息，可以直接回复小诺1. 热销机型；2. 精彩应用推荐；3. 缤纷活动。轻松找到最对你口味的消息哦~也可直接点击屏幕下方，查询更多有意思的内容~";
                    $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
            }




            //诺基亚影院行活动监测
            if(strpos($keyword, '诺基亚影院行') !== false){
                //记录openid
                $openid = strval($fromUsername);
                $Status = M('Status');
                $where = array();
                $where['openid'] = $openid;
                if($Status -> where($where) -> find()){
                    $contentStr = "欢迎您参加诺基亚影院行活动！请发送您的图片给我们，之后您将获得相应的优惠券！";
                }else{
                    $data = array();
                    $data['openid'] = $openid;
                    $data['status'] = 1;
                    if($Status -> add($data)){
                        $contentStr = "欢迎您参加诺基亚影院行活动！请发送您的图片给我们，之后您将获得相应的优惠券！";
                    }else{
                        $contentStr = "服务器开小差了，请您稍后再试哦！";
                    }
                }
                $msgType = 'text';
                $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
            }

            echo $resultStr;
        //相反为事件推送
        }else{
            //取消订阅事件不处理
            if($Event == 'unsubscribe'){
                echo '';
                exit();
            }
            $msgType = "text";
            $have = '';
            //已经领取过
            $have = M('Key') -> field('key,time') -> where(array('openID' => md5($fromUsername))) -> find();
            if($have){
                $contentStr = "感谢你关注诺基亚官方微信~想获得你感兴趣的相关诺基亚讯息，可以直接回复小诺1. 热销机型；2. 精彩应用推荐；3. 缤纷活动。轻松找到最对你口味的消息哦~也可直接点击屏幕下方，查询更多有意思的内容~";
            }else{
            //读取激活码
                $key = M('Key') -> field('id,key') -> where('openID=""') -> find();
                //设置激活码为无效
                $save_data = array();
                $save_data['openID'] = md5($fromUsername);
                $save_data['time'] = $time;
                $save_data['id'] = $key['id'];
                M('Key') -> save($save_data);
                $contentStr = '欢迎加入诺基亚官方微信！恭喜您获得迅雷电影院影视VIP7天体验券（激活码：' . $key["key"] .'）！观影特权+服务特权的双重豪礼，给你VIP级别的超爽体验！最新最热门的高清大片，想怎么看就怎么看！点击这里：http://m.vip.kankan.com/usekey.html立即激活体验吧！';

                //激活码送完了
                if(!$key){
                    $contentStr = "感谢你关注诺基亚官方微信~想获得你感兴趣的相关诺基亚讯息，可以直接回复小诺1. 热销机型；2. 精彩应用推荐；3.缤纷活动。轻松找到最对你口味的消息哦~也可直接点击屏幕下方，查询更多有意思的内容~";
                }
            }


            $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
            echo $resultStr;
        }
    }

        public function counts(){
            $use = M('Key') -> where('openID <> ""') -> count();
            $nouse = M('Key') -> where('openID = ""') -> count();
            $this -> show('<h3>激活码已用：<span style="color: blue;">' . $use . '</span> 条，未用：<span style="color:red;">' . $nouse . '</span> 条</h3>');
        }


    //回复文本消息
    public function responseText($toUserName, $fromUserName, $content){
        $textTpl = "<xml>
                    <ToUserName><![CDATA[%s]]></ToUserName>
                    <FromUserName><![CDATA[%s]]></FromUserName>
                    <CreateTime>%s</CreateTime>
                    <MsgType><![CDATA[%s]]></MsgType>
                    <Content><![CDATA[%s]]></Content>
                    <FuncFlag>0</FuncFlag>
                    </xml>";
        $resultStr = sprintf($textTpl, $fromUserName, $toUserName, time(), 'text', $content);
        echo $resultStr;
        exit;
    }

    //回复图文消息
    public function responseNews($toUserName, $fromUserName, $Articles){
        $textTpl = "<xml>
                    <ToUserName><![CDATA[" . $fromUserName . "]]></ToUserName>
                    <FromUserName><![CDATA[" . $toUserName . "]]></FromUserName>
                    <CreateTime>" . time() . "</CreateTime>
                    <MsgType><![CDATA[news]]></MsgType>
                    <ArticleCount>" . count($Articles) . "</ArticleCount>
                    <Articles>";

        foreach($Articles as $value){
            $textTpl .= "<item>
                         <Title><![CDATA[" . $value['title'] . "]]></Title>
                         <Description><![CDATA[" . $value['description'] . "]]></Description>
                         <PicUrl><![CDATA[" . $value['picurl'] . "]]></PicUrl>
                         <Url><![CDATA[" . $value['url'] . "]]></Url>
                         </item>";
        }

        $textTpl .= "</Articles>
                     </xml>";

        echo $textTpl;
        exit;

    }

}