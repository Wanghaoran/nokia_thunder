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

        $EventKey = $postObj -> EventKey;

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
                            'picurl' => 'http:/42.121.116.205/nokia_wechat/Public/images/a1.jpg',
                            'url' => 'http://mp.weixin.qq.com/s?__biz=MjM5Mjk2MjA0MA==&mid=200806259&idx=1&sn=bf0a271c79ed7ae0a84a0b2ce091d356#rd',
                        ),
                        array(
                            'title' => '参数配置',
                            'description' => '',
                            'picurl' => 'http:/42.121.116.205/nokia_wechat/Public/images/a2.jpg',
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
                            'picurl' => 'http:/42.121.116.205/nokia_wechat/Public/images/a3.jpg',
                            'url' => 'http://mp.weixin.qq.com/s?__biz=MjM5Mjk2MjA0MA==&mid=200806717&idx=1&sn=394403cda220c3a21422f83bc5a7211e#rd',
                        ),
                        array(
                            'title' => '参数配置',
                            'description' => '',
                            'picurl' => 'http:/42.121.116.205/nokia_wechat/Public/images/a4.jpg',
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
                            'picurl' => 'http:/42.121.116.205/nokia_wechat/Public/images/a5.jpg',
                            'url' => 'http://mp.weixin.qq.com/s?__biz=MjM5Mjk2MjA0MA==&mid=200806623&idx=1&sn=2880e20ca78be25cbb8ac88daef24447#rd',
                        ),
                        array(
                            'title' => '参数配置',
                            'description' => '',
                            'picurl' => 'http:/42.121.116.205/nokia_wechat/Public/images/a6.jpg',
                            'url' => 'http://mp.weixin.qq.com/s?__biz=MjM5Mjk2MjA0MA==&mid=200806623&idx=2&sn=535893af28f29b92eb05699a174d61cd#rd',
                        ),
                    );
                    $this -> responseNews($toUsername, $fromUsername, $Articles);
                break;

                case 'd':
                    $Articles = array(
                        array(
                            'title' => '诺基亚130 双卡双待',
                            'description' => '',
                            'picurl' => 'http://mmbiz.qpic.cn/mmbiz/3RdqPmGN9EvCYSjpDQaxHlMvKsZAbibntoHKuPoJQWNq8jOnt6oibsHERNIJQ1icw61AbR27crM8xM3HmhrTaK6xQ/0',
                            'url' => 'http://mp.weixin.qq.com/s?__biz=MjM5Mjk2MjA0MA==&mid=201148771&idx=1&sn=96fca66a1139e5e07b4c00c89df10650#rd',
                        ),
                        array(
                            'title' => '参数配置',
                            'description' => '',
                            'picurl' => 'http:/42.121.116.205/nokia_wechat/Public/images/a17.jpg',
                            'url' => 'http://mp.weixin.qq.com/s?__biz=MjM5Mjk2MjA0MA==&mid=201148771&idx=2&sn=4e91869460f17de6450e6b4abb3547c5#rd',
                        ),
                    );
                    $this -> responseNews($toUsername, $fromUsername, $Articles);
                break;

                case 'e':
                    $content = "小诺为大家整理了目前热门畅销机型，直接输入以下产品型号即可查看产品信息\n●LUMIA 638\n●LUMIA 1520\n●诺基亚X\n●诺基亚XL4G\n●诺基亚503\n●诺基亚1080\n●诺基亚225\n●LUMIA 630";
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
                            'picurl' => 'http:/42.121.116.205/nokia_wechat/Public/images/a1.jpg',
                            'url' => 'http://mp.weixin.qq.com/s?__biz=MjM5Mjk2MjA0MA==&mid=200806259&idx=1&sn=bf0a271c79ed7ae0a84a0b2ce091d356#rd',
                        ),
                        array(
                            'title' => '参数配置',
                            'description' => '',
                            'picurl' => 'http:/42.121.116.205/nokia_wechat/Public/images/a2.jpg',
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
                            'picurl' => 'http:/42.121.116.205/nokia_wechat/Public/images/a9.jpg',
                            'url' => 'http://mp.weixin.qq.com/s?__biz=MjM5Mjk2MjA0MA==&mid=200810263&idx=1&sn=2653c9960cfd08da4dcfe3522913c06b#rd',
                        ),
                        array(
                            'title' => '参数配置',
                            'description' => '',
                            'picurl' => 'http:/42.121.116.205/nokia_wechat/Public/images/a10.jpg',
                            'url' => 'http://mp.weixin.qq.com/s?__biz=MjM5Mjk2MjA0MA==&mid=200810263&idx=2&sn=038d938a542c09d2518379a8f416c533#rd',
                        ),
                    );
                    $this -> responseNews($toUsername, $fromUsername, $Articles);
                    break;

                case 'x':
                case 'nokia x':
                case '诺基亚x':
                    $Articles = array(
                        array(
                            'title' => ' 诺基亚 X 快速开启 Android应用',
                            'description' => '',
                            'picurl' => 'http:/42.121.116.205/nokia_wechat/Public/images/a11.jpg',
                            'url' => 'http://mp.weixin.qq.com/s?__biz=MjM5Mjk2MjA0MA==&mid=200810346&idx=1&sn=dc866ce157b8db05d7c2168ad5864e5e#rd',
                        ),
                        array(
                            'title' => '参数配置',
                            'description' => '',
                            'picurl' => 'http:/42.121.116.205/nokia_wechat/Public/images/a12.jpg',
                            'url' => 'http://mp.weixin.qq.com/s?__biz=MjM5Mjk2MjA0MA==&mid=200810346&idx=2&sn=39c02cc25624ec04c336ede5721e09c3#rd',
                        ),
                    );
                    $this -> responseNews($toUsername, $fromUsername, $Articles);
                    break;

                case '诺基亚xl4g':
                case '诺基亚xl':
                case 'xl':
                case 'xl4g':
                    $Articles = array(
                        array(
                            'title' => '诺基亚XL 4G 跨界而来',
                            'description' => '',
                            'picurl' => 'http:/42.121.116.205/nokia_wechat/Public/images/a5.jpg',
                            'url' => 'http://mp.weixin.qq.com/s?__biz=MjM5Mjk2MjA0MA==&mid=200806623&idx=1&sn=2880e20ca78be25cbb8ac88daef24447#rd',
                        ),
                        array(
                            'title' => '参数配置',
                            'description' => '',
                            'picurl' => 'http:/42.121.116.205/nokia_wechat/Public/images/a6.jpg',
                            'url' => 'http://mp.weixin.qq.com/s?__biz=MjM5Mjk2MjA0MA==&mid=200806623&idx=2&sn=535893af28f29b92eb05699a174d61cd#rd',
                        ),
                    );
                    $this -> responseNews($toUsername, $fromUsername, $Articles);
                    break;

                case '503':
                case '诺基亚503':
                case 'nokia503':
                    $Articles = array(
                        array(
                            'title' => '诺基亚503 小身材 大智慧',
                            'description' => '',
                            'picurl' => 'http:/42.121.116.205/nokia_wechat/Public/images/a3.jpg',
                            'url' => 'http://mp.weixin.qq.com/s?__biz=MjM5Mjk2MjA0MA==&mid=200806717&idx=1&sn=394403cda220c3a21422f83bc5a7211e#rd',
                        ),
                        array(
                            'title' => '参数配置',
                            'description' => '',
                            'picurl' => 'http:/42.121.116.205/nokia_wechat/Public/images/a4.jpg',
                            'url' => 'http://mp.weixin.qq.com/s?__biz=MjM5Mjk2MjA0MA==&mid=200806717&idx=2&sn=40e03a269aa412720896d2c4b9c8a6b3#rd',
                        ),
                    );
                    $this -> responseNews($toUsername, $fromUsername, $Articles);
                    break;

                case '130':
                case '诺基亚130':
                    $Articles = array(
                        array(
                            'title' => '诺基亚130 双卡双待',
                            'description' => '',
                            'picurl' => 'http://mmbiz.qpic.cn/mmbiz/3RdqPmGN9EvCYSjpDQaxHlMvKsZAbibntoHKuPoJQWNq8jOnt6oibsHERNIJQ1icw61AbR27crM8xM3HmhrTaK6xQ/0',
                            'url' => 'http://mp.weixin.qq.com/s?__biz=MjM5Mjk2MjA0MA==&mid=201148771&idx=1&sn=96fca66a1139e5e07b4c00c89df10650#rd',
                        ),
                        array(
                            'title' => '参数配置',
                            'description' => '',
                            'picurl' => 'http:/42.121.116.205/nokia_wechat/Public/images/a17.jpg',
                            'url' => 'http://mp.weixin.qq.com/s?__biz=MjM5Mjk2MjA0MA==&mid=201148771&idx=2&sn=4e91869460f17de6450e6b4abb3547c5#rd',
                        ),
                    );
                    $this -> responseNews($toUsername, $fromUsername, $Articles);
                    break;

                case '1080':
                case '诺基亚1080':
                case 'nokia1080':
                    $Articles = array(
                        array(
                            'title' => '诺基亚1080 双卡双待',
                            'description' => '',
                            'picurl' => 'http:/42.121.116.205/nokia_wechat/Public/images/a13.jpg',
                            'url' => 'http://mp.weixin.qq.com/s?__biz=MjM5Mjk2MjA0MA==&mid=200810093&idx=1&sn=c98b214a7e6a707691fbc18d6cc95947#rd',
                        ),
                        array(
                            'title' => '参数配置',
                            'description' => '',
                            'picurl' => 'http:/42.121.116.205/nokia_wechat/Public/images/a14.jpg',
                            'url' => 'http://mp.weixin.qq.com/s?__biz=MjM5Mjk2MjA0MA==&mid=200810093&idx=2&sn=4c8b9a062a1a0f1fb80b46292ac87ee0#rd',
                        ),
                    );
                    $this -> responseNews($toUsername, $fromUsername, $Articles);
                    break;

                case '225':
                case '诺基亚225':
                case 'nokia225':
                    $Articles = array(
                        array(
                            'title' => '诺基亚225 双卡双待',
                            'description' => '',
                            'picurl' => 'http:/42.121.116.205/nokia_wechat/Public/images/a7.jpg',
                            'url' => 'http://mp.weixin.qq.com/s?__biz=MjM5Mjk2MjA0MA==&mid=200806722&idx=1&sn=18401294f13527b96b11bf9466901236#rd',
                        ),
                        array(
                            'title' => '参数配置',
                            'description' => '',
                            'picurl' => 'http:/42.121.116.205/nokia_wechat/Public/images/a8.jpg',
                            'url' => 'http://mp.weixin.qq.com/s?__biz=MjM5Mjk2MjA0MA==&mid=200806722&idx=2&sn=af1039cbd1ac640032389fd3d3b05c97#rd',
                        ),
                    );
                    $this -> responseNews($toUsername, $fromUsername, $Articles);
                    break;

                case '630':
                case '诺基亚630':
                case 'nokia630':
                    $Articles = array(
                        array(
                            'title' => '诺基亚LUMIA630 双卡双待',
                            'description' => '',
                            'picurl' => 'http:/42.121.116.205/nokia_wechat/Public/images/a15.jpg',
                            'url' => 'http://mp.weixin.qq.com/s?__biz=MjM5Mjk2MjA0MA==&mid=200809505&idx=1&sn=56415cc9565dde5046d8124e15c2bf9a#rd',
                        ),
                        array(
                            'title' => '参数配置',
                            'description' => '',
                            'picurl' => 'http:/42.121.116.205/nokia_wechat/Public/images/a16.jpg',
                            'url' => 'http://mp.weixin.qq.com/s?__biz=MjM5Mjk2MjA0MA==&mid=200809505&idx=2&sn=94d50e8f0fb3d79871ade0db2e7fd574#rd',
                        ),
                    );
                    $this -> responseNews($toUsername, $fromUsername, $Articles);
                    break;

                case '我是帮友':

                    $uri = "http://182.92.64.207/nokia_share/index/getuserdate";
                    // 参数数组
                    $data = array (
                        'openid' => strval($fromUsername),
                        'type' => 'wechat',
                    );

                    $ch = curl_init ();
                    curl_setopt ( $ch, CURLOPT_URL, $uri );
                    curl_setopt ( $ch, CURLOPT_POST, 1 );
                    curl_setopt ( $ch, CURLOPT_HEADER, 0 );
                    curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
                    curl_setopt ( $ch, CURLOPT_POSTFIELDS, $data );
                    $return = curl_exec ( $ch );
                    curl_close ( $ch );

                    $result = json_decode($return, true);

                    if($result['state'] == 'error'){
                        $contentStr = '您还未参加此活动，点击菜单缤纷活动－拉帮皆友一起享参加吧！';
                    }else{
                        $contentStr = "已经有 " . $result['sum'] . " 人通过你的二维码购买了产品\n你帮友的排名是：第 " . $result['rank'] . " 名";
                    }

                    $msgType = 'text';
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

            //菜单点击
            if($Event == 'CLICK'){
                switch($EventKey){
                    case 'NOWS':
                        $Articles = array(
                            array(
                                'title' => 'Lumia930震撼上市 让你悦然心动',
                                'description' => '一脉相承、高端体验、彰显个性，所有的所有都让你悦然心动 这就是Lumia930',
                                'picurl' => 'http://mmbiz.qpic.cn/mmbiz/3RdqPmGN9Eu770snUpkAsFlukoibFD6UFfuEOZibQQuLNfSDDoofzM8AQ8jaKeyIsGqoV98S7l4IEPLkQqAbeWZA/640',
                                'url' => 'http://mp.weixin.qq.com/s?__biz=MjM5Mjk2MjA0MA==&mid=200928289&idx=1&sn=48e3b5b131998d1c921a1bf85a1707f0#rd',
                            ),
                        );
                        $this -> responseNews($toUsername, $fromUsername, $Articles);
                        break;

                    case 'SMART':
                        $Articles = array(
                            array(
                                'title' => 'Lumia930&smart合体记',
                                'description' => '带上你的耳机，点击视频选择超清画质，一起来感受下来自现场的原汁原味。',
                                'picurl' => 'https://mmbiz.qlogo.cn/mmbiz/3RdqPmGN9EvfQ3MUgkBsabQZeyb8zyGJmQ3IQwlf2k8KmdPf7x5rrbB4hYqFLl6yVibiaOD7HsOQD0QAicBEuu9mQ/0',
                                'url' => 'http://mp.weixin.qq.com/s?__biz=MjM5Mjk2MjA0MA==&mid=201114440&idx=1&sn=381e56295052276323fc7a9f4072d453#rd',
                            ),
                        );
                        $this -> responseNews($toUsername, $fromUsername, $Articles);
                        break;

                    case 'PLACE':
                        $Articles = array(
                            array(
                                'title' => 'Lumia930带你「看」国家地理',
                                'description' => '这是我们用Lumia拍摄世界七大自然奇景的第一站，由美国国家地理杂志摄影师Stephen Alvarez带队前往尼泊尔，用Lumia 930和Lumia 1520来拍摄珠穆朗玛峰的壮丽景观。',
                                'picurl' => 'https://mmbiz.qlogo.cn/mmbiz/3RdqPmGN9EvfQ3MUgkBsabQZeyb8zyGJaaNn2NKzSsnicPduHtDE6kBNOQaicTk1qK8YGAM0keoNRwx0UdrI7lwg/0',
                                'url' => 'http://mp.weixin.qq.com/s?__biz=MjM5Mjk2MjA0MA==&mid=201114534&idx=1&sn=0c9580b976a288b222dc17cd9e15cf49#rd',
                            ),
                        );
                        $this -> responseNews($toUsername, $fromUsername, $Articles);
                        break;

                    case 'CORTANA':
                        $Articles = array(
                            array(
                                'title' => 'Cortana小课堂 | 方便你的生活',
                                'description' => '有了小娜，你是不是发现平日的生活方便了不少？她会记录下你的点点滴滴，成为你必不可少的好朋友而今天，Corta',
                                'picurl' => 'https://mmbiz.qlogo.cn/mmbiz/3RdqPmGN9EvfQ3MUgkBsabQZeyb8zyGJAkbUd4PSP0bLXntibH25PMYM1mMibIIj3WPaoOicFgu8oEZXa2qDR6FvA/0',
                                'url' => 'http://mp.weixin.qq.com/s?__biz=MjM5Mjk2MjA0MA==&mid=201115349&idx=1&sn=b6b21509c6a80b271da32e192f2dbf60#rd',
                            ),
                        );
                        $this -> responseNews($toUsername, $fromUsername, $Articles);
                        break;

                    case 'GAME':
                        $Articles = array(
                            array(
                                'title' => '创意小游戏 | 乐趣停不住',
                                'description' => '贪吃蛇又回来了！机智的小诺通过「Lumia530」的动态磁贴原景重现了这个经典画面，玩过这个游戏的诺粉请回复',
                                'picurl' => 'https://mmbiz.qlogo.cn/mmbiz/3RdqPmGN9EvfQ3MUgkBsabQZeyb8zyGJX2z2zoq0IxGcdhLQhqPziaKs8b6C7xbHpUkiaZRRoE1lcXGbotY39HFQ/0',
                                'url' => 'http://mp.weixin.qq.com/s?__biz=MjM5Mjk2MjA0MA==&mid=201114664&idx=1&sn=ddb5fce3b96f57b8f8e75ed879fcd839#rd',
                            ),
                        );
                        $this -> responseNews($toUsername, $fromUsername, $Articles);
                        break;

                    case 'TIPS':
                        $Articles = array(
                            array(
                                'title' => 'WP系统Tips | 个性化你的主屏幕',
                                'description' => '',
                                'picurl' => 'http://mmbiz.qpic.cn/mmbiz/3RdqPmGN9EvCYSjpDQaxHlMvKsZAbibntkB9JAjooPvlQxibiae881e1zzPSlEkjYj0aQrmyl8T8VFwX6TQq3pJCg/0',
                                'url' => 'http://mp.weixin.qq.com/s?__biz=MjM5Mjk2MjA0MA==&mid=201147597&idx=1&sn=97f6440e8900f7297ea11078bfcaf87c#rd',
                            ),
                            array(
                                'title' => 'WP系统Tips | 更懂你的输入法',
                                'description' => '',
                                'picurl' => 'http://mmbiz.qpic.cn/mmbiz/3RdqPmGN9EvCYSjpDQaxHlMvKsZAbibntyEfhaycHca4EVGicu5otVVBHuKMX0nWWNYKlFMianSyjNur4eic7sJZYw/0',
                                'url' => 'http://mp.weixin.qq.com/s?__biz=MjM5Mjk2MjA0MA==&mid=201147597&idx=2&sn=0b0ff4e16be6b359e66b8854532e84c3#rd',
                            ),
                        );
                        $this -> responseNews($toUsername, $fromUsername, $Articles);
                        break;

                    case 'APP':
                        $Articles = array(
                            array(
                                'title' => ' 好用又好玩的APP们-国庆特辑',
                                'description' => '国庆假期怎么过？除了吃喝玩乐以外，好用又好玩的APP们肯定也少不了，现在就跟着小诺的步伐来看看【好用又好玩的APP们-国庆特辑】让这个假期乐趣无限',
                                'picurl' => 'http://mmbiz.qpic.cn/mmbiz/3RdqPmGN9EvCYSjpDQaxHlMvKsZAbibntzcfw31ytuoqntjUM1YrLFOVaibPmuoJicMWdiaXBVlyep9AcialCOr7vfQ/0',
                                'url' => 'http://mp.weixin.qq.com/s?__biz=MjM5Mjk2MjA0MA==&mid=201115431&idx=1&sn=0a7af39d5b3801a6c54f45ed7b4ebb76#rd',
                            ),
                        );
                        $this -> responseNews($toUsername, $fromUsername, $Articles);
                        break;

                    case 'BUAUTLY':
                        $Articles = array(
                            array(
                                'title' => ' ​Cortana来了！美女光圈人带你游京城',
                                'description' => '',
                                'picurl' => 'http://mmbiz.qpic.cn/mmbiz/3RdqPmGN9Euicpg5cYQrPGUtib2LF4VhkXo1nz8NTqBpmW7uzpjHuql3yQkCnSIwEyBCSkD9xv9fmcVdUV5LPib3w/0',
                                'url' => 'http://mp.weixin.qq.com/s?__biz=MjM5Mjk2MjA0MA==&mid=201244974&idx=1&sn=c047ead10bf2836d2554996eb6d048cd#rd',
                            ),
                            array(
                                'title' => '邂逅美女光圈人，携手进入智能语音新时代',
                                'description' => '',
                                'picurl' => 'https://mmbiz.qlogo.cn/mmbiz/3RdqPmGN9Euicpg5cYQrPGUtib2LF4VhkXqh9lJKW0vonmGuMnapzpR4psznPlnIENDcCTGhrGiaJSh1eefDWFDZA/0',
                                'url' => 'http://mp.weixin.qq.com/s?__biz=MjM5Mjk2MjA0MA==&mid=201244974&idx=2&sn=ba50924bacad985358ee66a63c91b9e2#rd',
                            ),
                        );
                        $this -> responseNews($toUsername, $fromUsername, $Articles);
                        break;

                    case 'DAILY':
                        $Articles = array(
                            array(
                                'title' => '小娜与你的日常',
                                'description' => '当小娜来到你的身边，你们会产生什么火花？当小娜成为了你的朋友，你们的生活会是什么样？来点击视频，告诉你小娜到底有多机智',
                                'picurl' => 'http://mmbiz.qpic.cn/mmbiz/3RdqPmGN9Esr1bfAFJ4OQjlUY6nmP14iaWm8frBvlhGLjtZ0WkOzPDY1ibj6krMFq0XAKje9lEppKqXeLMIm96qA/0',
                                'url' => 'http://mp.weixin.qq.com/s?__biz=MjM5Mjk2MjA0MA==&mid=201421908&idx=1&sn=80242081b8bbd9f126957cf194597f51#rd',
                            ),
                        );
                        $this -> responseNews($toUsername, $fromUsername, $Articles);
                        break;
                }
            }


            //如果有事件Key值，说明扫描了带参二维码
            if(!empty($EventKey)){
                $WechatSourceStatistical = D('WechatSourceStatistical');
                //用户扫描后关注
                if($Event == 'subscribe'){
                    $re = $WechatSourceStatistical -> addnum(1);
                //用户已关注扫描
                }else if($Event == 'SCAN'){
                    $re = $WechatSourceStatistical -> addnum(2);
                }
            }

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
            exit();
        }
    }

        public function counts(){
            $use = M('Key') -> where('openID <> ""') -> count();
            $nouse = M('Key') -> where('openID = ""') -> count();
            $this -> show('<h3>激活码已用：<span style="color: blue;">' . $use . '</span> 条，未用：<span style="color:red;">' . $nouse . '</span> 条</h3>');
        }

    public function wechat_source(){
        $WechatSourceStatistical = M('WechatSourceStatistical');
        $da_arr = array();
        $da_arr[] = date('Y-m-d');
        $key1_arr[] = 0;
        $key2_arr[] = 0;
        //生成日期数组，每次减少1天
        for($i=1; $i < 10; $i++){
            $da_arr[] = date('Y-m-d', strtotime("-{$i} day"));
            $key1_arr[] = 0;
            $key2_arr[] = 0;
        }
        $this -> assign('da_arr', json_encode(array_reverse($da_arr)));
        //根据日期数组查询结果
        $result = $WechatSourceStatistical -> where(array('date' => array('IN', $da_arr))) -> select();
        foreach($result as $value){
            $key = array_search($value['date'], $da_arr);
            if($key !== false){
                $key1_arr[$key] = $value['key1'];
                $key2_arr[$key] = $value['key2'];
            }
        }
        $this -> assign('key1_arr', json_encode(array_reverse($key1_arr)));
        $this -> assign('key2_arr', json_encode(array_reverse($key2_arr)));

        //有效扫描总次数
        $total = $WechatSourceStatistical -> sum('key1+key2');
        //用户扫描后关注总次数
        $key1_total = $WechatSourceStatistical -> sum('key1');
        //已关注用户扫描总次数
        $key2_total = $total - $key1_total;
        $this -> assign('total', $total);
        $this -> assign('key1_total', $key1_total);
        $this -> assign('key2_total', $key2_total);


        $this -> display();
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