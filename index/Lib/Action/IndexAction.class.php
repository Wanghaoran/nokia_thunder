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
            $msgType = "text";
            if($fromUsername == 'o-LOhjtv64tp_EHRZhUdUajBFayU'){
                $contentStr = 'Hello! 王钰，这是专属于你的优惠码:12345677';
            }else{
                $contentStr = "哎哟，恭喜恭喜啊，你终于也关注诺基亚官方微信啦。这里可有很多关于诺基亚的资讯哦，直接回复“NOKIA”，来了解一下如何为你的手机定制专属信息吧。如果你想了解其它热
销产品，就回复相关型号，小诺在这里包学包会包了解。" . $fromUsername;
            }
            $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
            echo $resultStr;
        }

    }
}