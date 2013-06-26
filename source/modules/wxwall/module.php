<?php
/**
 * 微信墙模块
 *
 * [WeEngine System] Copyright (c) 2013 WE7.CC
 */
defined('IN_IA') or exit('Access Denied');

class WxwallModule extends WeModule {
	public $name = 'Wxwall';
	public $title = '微信墙';
	public $ability = '';
    public $tablename = 'wxwall_reply';
	public $emotions = array("/::)","/::~","/::B","/::|","/:8-)","/::<","/::$","/::X","/::Z","/::'(","/::-|","/::@","/::P","/::D","/::O","/::(","/::+","/:--b","/::Q","/::T","/:,@P","/:,@-D","/::d","/:,@o","/::g","/:|-)","/::!","/::L","/::>","/::,@","/:,@f","/::-S","/:?","/:,@x","/:,@@","/::8","/:,@!","/:!!!","/:xx","/:bye","/:wipe","/:dig","/:handclap","/:&-(","/:B-)","/:<@","/:@>","/::-O","/:>-|","/:P-(","/::'|","/:X-)","/::*","/:@x","/:8*","/:pd","/:<W>","/:beer","/:basketb","/:oo","/:coffee","/:eat","/:pig","/:rose","/:fade","/:showlove","/:heart","/:break","/:cake","/:li","/:bome","/:kn","/:footb","/:ladybug","/:shit","/:moon","/:sun","/:gift","/:hug","/:strong","/:weak","/:share","/:v","/:@)","/:jj","/:@@","/:bad","/:lvu","/:no","/:ok","/:love","/:<L>","/:jump","/:shake","/:<O>","/:circle","/:kotow","/:turn","/:skip","/:oY","/:#-0","/:hiphot","/:kiss","/:<&","/:&>");

	public function fieldsFormDisplay($rid = 0) {
	    global $_W;
	    if (!empty($rid)) {
	    	$reply = pdo_fetch("SELECT * FROM ".tablename($this->tablename)." WHERE rid = :rid ORDER BY `id` DESC", array(':rid' => $rid));
	    }
		include $this->template('wxwall:form');
	}

	public function fieldsFormValidate($rid = 0) {
		return true;
	}

	public function fieldsFormSubmit($rid = 0) {
		global $_GPC, $_W;
		$id = intval($_GPC['reply_id']);
		$insert = array(
			'rid' => $rid,
			'enter_tips' => $_GPC['enter-tips'],
			'quit_tips' => $_GPC['quit-tips'],
			'send_tips' => $_GPC['send-tips'],
			'timeout' => $_GPC['timeout'],
			'isshow' => intval($_GPC['isshow']),
			'quit_command' => $_GPC['quit-command']
		);
		if (empty($id)) {
			pdo_insert($this->tablename, $insert);
		} else {
			pdo_update($this->tablename, $insert, array('id' => $id));
		}
	}

	public function ruleDeleted($rid = 0) {

	}

	public function doDetail() {
		global $_GPC, $_W;
		$id = intval($_GPC['id']);

		$wall = pdo_fetch("SELECT id, isshow, rid FROM ".tablename('wxwall_reply')." WHERE rid = '{$id}' LIMIT 1");
		$wall['name'] = pdo_fetchcolumn("SELECT name FROM ".tablename('rule')." WHERE id = '{$id}' LIMIT 1");
		$list = pdo_fetchall("SELECT * FROM ".tablename('wxwall_message')." WHERE rid = '{$wall['rid']}' AND isshow = '1' ORDER BY createtime DESC LIMIT 3");
		$onlinemember = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename('wxwall_members')." WHERE rid = '{$wall['rid']}'");
		if (!empty($list)) {
			foreach ($list as &$row) {
			    $row['member'] = pdo_fetch("SELECT nickname, avatar FROM ".tablename('wxwall_members')." WHERE from_user = '{$row['from_user']}'");
				if ($row['type'] == 'link') {
					$row['content'] = iunserializer($row['content']);
					$row['content'] = '<a href="'.$row['content']['link'].'" target="_blank" title="'.$row['content']['description'].'">'.$row['content']['title'].'</a>';
				} elseif ($row['type'] == 'image') {
					$row['content'] = '<img src="'.$_W['attachurl'] . $row['content'].'" />';
				}
				foreach ($this->emotions as $index => $emotions) {
					$row['content'] = str_replace($emotions, '<img style="width:48px; vertical-align:middle;" src="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/'.$index.'.gif" />', $row['content']);
				}
			}
			unset($row);
		}
		include $this->template('wxwall:detail');
	}

	public function doManage() {
		global $_GPC, $_W;
		if (checksubmit('verify') && $_W['uid']) {
			pdo_update('wxwall_message', array('isshow' => 1), " id  IN  ('".implode("','", $_GPC['select'])."')");
		}
		if (checksubmit('delete') && $_W['uid']) {
			pdo_delete('wxwall_message', " id  IN  ('".implode("','", $_GPC['select'])."')");
		}
		$id = intval($_GPC['id']);
		$isshow = isset($_GPC['isshow']) ? intval($_GPC['isshow']) : 0;
		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;

		$wall = pdo_fetch("SELECT id, isshow, rid FROM ".tablename('wxwall_reply')." WHERE rid = '{$id}' LIMIT 1");
		$list = pdo_fetchall("SELECT * FROM ".tablename('wxwall_message')." WHERE rid = '{$wall['rid']}' AND isshow = '$isshow' ORDER BY createtime DESC LIMIT ".($pindex - 1) * $psize.",{$psize}");
		$onlinemember = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename('wxwall_members')." WHERE rid = '{$wall['rid']}'");
		if (!empty($list)) {
			$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('wxwall_message') . " WHERE rid = '{$wall['rid']}' AND isshow = '$isshow'");
			$pager = pagination($total, $pindex, $psize);

			foreach ($list as &$row) {
				if ($row['type'] == 'link') {
					$row['content'] = iunserializer($row['content']);
					$row['content'] = '<a href="'.$row['content']['link'].'" target="_blank" title="'.$row['content']['description'].'">'.$row['content']['title'].'</a>';
				} elseif ($row['type'] == 'image') {
					$row['content'] = '<img src="'.$_W['attachurl'] . $row['content'].'" />';
				}
			}
			unset($row);
		}
		include $this->template('wxwall:manage');
	}

	public function doIncoming() {
	    global $_GPC, $_W;
	    $id = intval($_GPC['id']);

	    $wall = pdo_fetch("SELECT id, isshow, rid FROM ".tablename('wxwall_reply')." WHERE rid = '{$id}' LIMIT 1");
	    $row = pdo_fetch("SELECT * FROM ".tablename('wxwall_message')." WHERE rid = '{$wall['rid']}' AND isshow = '1' ORDER BY createtime DESC LIMIT 1");
	    if (!empty($row)) {
	        $row['member'] = pdo_fetch("SELECT nickname, avatar FROM ".tablename('wxwall_members')." WHERE from_user = '{$row['from_user']}'");
            if ($row['type'] == 'link') {
                $row['content'] = iunserializer($row['content']);
                $row['content'] = '<a href="'.$row['content']['link'].'" target="_blank" title="'.$row['content']['description'].'">'.$row['content']['title'].'</a>';
            } elseif ($row['type'] == 'image') {
                $row['content'] = '<img src="'.$_W['attachurl'] . $row['content'].'" />';
            }
			foreach ($this->emotions as $index => $emotions) {
				$row['content'] = str_replace($emotions, '<img style="width:48px;" src="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/'.$index.'.gif" />', $row['content']);
			}
	    }
	    message($row);
	}

	public function doRegister() {
	    global $_GPC, $_W;
	    $member = pdo_fetch("SELECT id, nickname, avatar FROM ".tablename('wxwall_members')." WHERE from_user = '{$_GPC['from']}' LIMIT 1");
	    if (!empty($_GPC['submit'])) {
	        $data = array(
	            'nickname' => $_GPC['nickname'],
	        );
	        if (empty($data['nickname'])) {
	            die('<script>alert("请填写您的昵称！");location.reload();</script>');
	        }
	        if (!empty($_FILES['avatar']['tmp_name'])) {
	            $_W['uploadsetting'] = array();
	            $_W['uploadsetting']['wxwall']['folder'] = 'wxwall/avatar';
	            $_W['uploadsetting']['wxwall']['extentions'] = $_W['config']['upload']['image']['extentions'];
	            $_W['uploadsetting']['wxwall']['limit'] = $_W['config']['upload']['image']['limit'];
	            $upload = file_upload($_FILES['avatar'], 'wxwall', $_GPC['from']);
    	        if (is_error($upload)) {
        			die('<script>alert("登记失败！请重试！");location.reload();</script>');
        		}
        		$data['avatar'] = $upload['path'];
	        }
	        pdo_update('wxwall_members', $data, array('from_user' => $_GPC['from']));
	        die('<script>alert("登记成功！现在进入话题发表内容！");location.href = "'.create_url('index/module', array('name' => 'wxwall', 'do' => 'register', 'from' => $_GPC['from'])).'";</script>');

	    }
	    include $this->template('wxwall:register');
	}

}