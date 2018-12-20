<?php
/**
 * Created by PhpStorm.
 * User: iBaiYang
 * Date: 2018/3/28
 * Time: 下午5:23
 */
namespace common\components;

use common\misc\LError;
use common\service\LLogRequestBlackListService;
use stdClass;
use Yii;
use yii\log\Logger;
use yii\web\Controller;
use yii\web\Response;

class LController extends Controller
{
    /**
     * @param mixed $result
     */
    public function ajaxResponse($result = array())
    {
        /** @var LHttpRequest $request */
        $request = Yii::$app->request;
        /** @var Response $response */
        $response = Yii::$app->response;
        $callback = $request->get('callback');
        if (empty($result))
        {
            $result = new stdClass();
        }

        if ($callback && is_string($callback) && preg_match('/^[0-9A-Za-z_]+$/', $callback))
        {
            $response->format = Response::FORMAT_JSONP;
            $response->content = 'try{' . $callback . '(' . json_encode($result) . ');}catch(e){}';
        }
        else
        {
            $response->format = Response::FORMAT_JSON;
            $response->content = json_encode($result,JSON_UNESCAPED_UNICODE);
        }
        $pathInfo = Yii::$app->request->getPathInfo();
        if (!LLogRequestBlackListService::inBlackList($pathInfo)) {
            $context['actionUrl'] = Yii::$app->request->getUrl();
            $context['result'] = $result;
            if ($context["result"]["data"])
            {
                $context["result"]["data"] = json_encode($context["result"]["data"]);
            }
            Yii::getLogger()->log($context, Logger::LEVEL_TRACE, "application");
        }
        Yii::$app->end(0, $response);
    }

    /**
     * @param array $data
     */
    public function ajaxSuccess(array $data = array())
    {
        $this->ajaxReturn(LError::SUCCESS, '', $data);
    }

    /**
     * @param int $code
     * @param array|string $msg
     * @param $data
     */
    public function ajaxReturn($code = LError::SUCCESS, $msg = array(), $data = null)
    {
        if (is_array($msg) || !$msg)
        {
            $msg = LError::getErrMsgByCode($code, $msg);
        }
        if (is_null($data))
        {
            $data = new stdClass();
        }
        else if (!$data){
            $data = [];
        }
        $this->ajaxResponse(array(
            'code' => $code,
            'msg' => $msg,
            'data' => $data,
        ));
    }
}