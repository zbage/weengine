<?php
defined('WEKIT_VERSION') or exit(403);

class IndexController extends PwBaseController {
    private $dao = null;
    private $entity = null;
    private $isBind = false;
	
	public function beforeAction($handlerAdapter) {
        parent::beforeAction($handlerAdapter);
        if (!$this->loginUser->isExists()) {
            $this->showError('login.not');
        }
        $this->dao = Wekit::loadDao('EXT:iweengine.service.dao.App_IWeEngine_Bind');
        $uid = $this->loginUser->uid;
        $this->entity = $this->dao->get($uid);
        $this->isBind = !empty($this->entity) && $this->entity['isbind'];
        $this->setOutput($this->isBind, 'isBind');
	}
	
	public function run() {
        if($this->isBind) {
            $this->manualAction();
        } else {
            $this->bindAction();
        }
	}

    public function manualAction() {
        $active = array();
        $active['manual'] = ' class="current"';
        $this->setOutput($active, 'active');
        $this->setOutput('操作使用说明', 'title');
        $this->setOutput('manual', 'content');
        $this->setTemplate('profile');
    }

    public function bindAction() {
        if($this->isBind) {
            $this->forwardRedirect(WindUrlHelper::createUrl('/app/index/manual?app=iweengine'));
        }
        $active = array();
        $active['bind'] = ' class="current"';
        $this->setOutput($active, 'active');
        $this->setOutput('绑定微信号', 'title');
        $settings = array();
        $settings['wechat'] = '';
        $settings['qrcode'] = '';
        $settings['username'] = $this->loginUser->username;
        $this->setOutput($settings, 'settings');
        $this->setOutput($this->codeGen(), 'code');
        $this->setOutput('bind', 'content');
        $this->setTemplate('profile');
    }

    public function unbindAction() {
        if(!$this->isBind) {
            $this->forwardRedirect(WindUrlHelper::createUrl('/app/index/bind?app=iweengine'));
        }
        $active = array();
        $active['unbind'] = ' class="current"';
        $this->setOutput($active, 'active');
        $this->setOutput('解除微信号绑定', 'title');
        $settings = array();
        $settings['wechat'] = '';
        $settings['username'] = $this->loginUser->username;
        $this->setOutput($settings, 'settings');
        $this->setOutput($this->codeGen(), 'code');
        $this->setOutput('unbind', 'content');
        $this->setTemplate('profile');
    }

    public function cometAction() {
        set_time_limit(0);
        $start = time();
        while(true && time() - $start < 60) {
            $bean = $this->dao->get($this->loginUser->uid);
            if($this->getInput('do') == 'bind' && !empty($bean) && $bean['isbind']) {
                exit('success');
            }
            if($this->getInput('do') == 'unbind' && (empty($bean) || !$bean['isbind'])) {
                exit('success');
            }
            sleep(1);
        }
        exit();
    }

    private function codeGen() {
        $code = rand(0, 999999);
        $code = sprintf('%6d', $code);
        if(empty($this->entity)) {
            $row = array();
            $row['uid'] = $this->loginUser->uid;
            $row['wechat'] = '';
            $row['dateline'] = '0';
            $row['isbind'] = false;
            $row['vcode'] = $code;
            $row['vtime'] = time();
            $this->dao->add($row);
        } else {
            if(time() - $this->entity['vtime'] < 300) {
                $code = $this->entity['vcode'];
            } else {
                $row = array();
                $row['vcode'] = $code;
                $row['vtime'] = time();
                $this->dao->update($this->loginUser->uid, $row);
            }
        }
        return $code;
    }
}
