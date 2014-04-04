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
        $toUsername = çç->ToUserName;
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

        $time = time();

        //有关键词的是消息推送
        if(!empty($keyword)){
            $msgType = "text";
            $contentStr = "诺基亚官方微信建设中....";
            $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
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
            //$have = M('Key') -> field('key,time') -> where(array('openID' => md5($fromUsername))) -> find();
            if($have){
                $contentStr = '您已经于' . date('Y-m-d H:i:s', $have['time']) . '领取过激活码，激活码为：' . $have['key'];
            }else{
                //读取激活码
                $key = M('Key') -> field('id,key') -> where('openID=""') -> find();
                //设置激活码为无效
                $save_data = array();
                $save_data['openID'] = md5($fromUsername);
                $save_data['time'] = $time;
                $save_data['id'] = $key['id'];
                M('Key') -> save($save_data);
                //王钰 和  我
                if($fromUsername == 'o-LOhjtv64tp_EHRZhUdUajBFayU' || $fromUsername == 'o-LOhjkS4YVgDRv9rtsQ9vg__sz4'){
                    $contentStr = '欢迎加入诺基亚官方微信！恭喜您获得迅雷电影院7天影视VIP体验卡（' . $key["key"] .'）！观影特权+服务特权的双重豪礼，给你VIP级别的超爽体验！最新最热门的高清大片，想怎么看就怎么看！';
                }else{
                    $contentStr = "哎哟，恭喜恭喜啊，你终于也关注诺基亚官方微信啦。这里可有很多关于诺基亚的资讯哦，直接回复“NOKIA”，来了解一下如何为你的手机定制专属信息吧。如果你想了解其它热
销产品，就回复相关型号，小诺在这里包学包会包了解。";
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