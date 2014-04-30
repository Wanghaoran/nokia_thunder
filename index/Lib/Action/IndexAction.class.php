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

        //有关键词的是消息推送
        if(!empty($keyword)){

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

                default:
                    $msgType = 'text';
                    $contentStr = "感谢你关注诺基亚官方微信~想获得你感兴趣的相关诺基亚讯息，可以直接回复小诺1. 热销机型；2. 精彩应用推荐；3. 缤纷活动。轻松找到最对你口味的消息哦~也可直接点击屏幕下方，查询更多有意思的内容~";
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