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
                    $contentStr = "四大系列，精彩各不相同！最想了解哪个呢？a. Lumia非凡系列 b. 诺基亚Asha新趣系列 c. 诺基亚X系列 d. 实用经典系列（回复a,b,c,d,即可）";
                    $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                break;

                case 'a':
                    $msgType = 'news';
                    $ArticleCount = 1;
                    $Title = 'Lumia非凡系列—诺基亚Lumia1520，让生活大有可言！';
                    $Description = '绝对震撼你的Lumia1520，完美你的工作与生活~';
                    $PicUrl = 'http://mmbiz.qpic.cn/mmbiz/3RdqPmGN9Euu6GnjhbtPheLIMPC7FQ9GRiaZmYMskGsynpCeS1HZpby2LHOZPr8VJHYjVrtSwpiagSADwyctQdjg/0';
                    $Url = 'http://mp.weixin.qq.com/s?__biz=MjM5Mjk2MjA0MA==&mid=200364162&idx=1&sn=e6dbc827a0ce6d5d841ce8f3f8436853#rd';
                    $resultStr = sprintf($textNews_one, $fromUsername, $toUsername, $time, $msgType, $ArticleCount, $Title, $Description, $PicUrl, $Url);
                break;

                case 'b':
                    $msgType = 'news';
                    $ArticleCount = 1;
                    $Title = '诺基亚Asha新趣系列—拥有丰富功能的Asha 503，一点都不简单！';
                    $Description = '小身材，大智慧。Asha 503展现精致魅力！';
                    $PicUrl = 'http://mmbiz.qpic.cn/mmbiz/3RdqPmGN9Euu6GnjhbtPheLIMPC7FQ9G9kcMBnXDatLuS2uTgVMzL5UnUvh3DmHLiahrjfB9YSk7UV583XONvNA/0';
                    $Url = 'http://mp.weixin.qq.com/s?__biz=MjM5Mjk2MjA0MA==&mid=200364158&idx=1&sn=f54c0a568423497ee767bad5a0c60ceb#rd';
                    $resultStr = sprintf($textNews_one, $fromUsername, $toUsername, $time, $msgType, $ArticleCount, $Title, $Description, $PicUrl, $Url);
                break;

                case 'c':
                    $msgType = 'news';
                    $ArticleCount = 1;
                    $Title = '诺基亚X系列—体验流畅的跨界体验，就拥有 Nokia X吧！';
                    $Description = '诺基亚X，带你领略独一无二的跨界风潮~';
                    $PicUrl = 'http://mmbiz.qpic.cn/mmbiz/3RdqPmGN9Euu6GnjhbtPheLIMPC7FQ9GOicmHGkn9fFGBUzswuevIXqPYZJKzQLwYTt44De6WDCKAeddheicGAvw/0';
                    $Url = 'http://mp.weixin.qq.com/s?__biz=MjM5Mjk2MjA0MA==&mid=200364160&idx=1&sn=7990df46e08cffa61db45a3f4f76bb7c#rd';
                    $resultStr = sprintf($textNews_one, $fromUsername, $toUsername, $time, $msgType, $ArticleCount, $Title, $Description, $PicUrl, $Url);
                break;

                case 'd':
                    $msgType = 'news';
                    $ArticleCount = 1;
                    $Title = '实用经典系列—诺基亚301，让你精彩多多，乐趣多多。';
                    $Description = '拥有大气简约的诺基亚301， 感受丰富智能的拍摄功能~';
                    $PicUrl = 'http://mmbiz.qpic.cn/mmbiz/3RdqPmGN9Euu6GnjhbtPheLIMPC7FQ9GQ23hhIITicXLcX6Nf4umPGVibX90icJAPKNlJSF6ribNp6cp5bzBiaqb3oQ/0';
                    $Url = 'http://mp.weixin.qq.com/s?__biz=MjM5Mjk2MjA0MA==&mid=200364164&idx=1&sn=1ef6debcf590d0e54947f5df88b09fbe#rd';
                    $resultStr = sprintf($textNews_one, $fromUsername, $toUsername, $time, $msgType, $ArticleCount, $Title, $Description, $PicUrl, $Url);
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
                    $contentStr = "感谢你关注诺基亚官方微信~想获得你感兴趣的相关诺基亚讯息，可以直接回复小诺1. 热销机型；2. 精彩应用推荐；3. 缤纷活动。轻松找到最对你口味的消息哦~也可直接点击屏幕下方，查询更多有意思的内容~";
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

}