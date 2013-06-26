<?php
/**
 * 图文回复模块
 * 
 * [WeEngine System] Copyright (c) 2013 WE7.CC
 */
defined('IN_IA') or exit('Access Denied');

class NewsModule extends WeModule {
	public $name = 'NewsChatRobotModule';
	public $title = '自定义回复';
	public $ability = '';
    public $tablename = 'news_reply';
    
	public function fieldsFormDisplay($rid = 0) {
	    global $_W;
		$result = pdo_fetchall("SELECT * FROM ".tablename($this->tablename)." WHERE rid = :rid ORDER BY `parentid` ASC, `id` ASC", array(':rid' => $rid));	
		$result = istripslashes($result);
		$reply = array();
		if (!empty($result)) {
		    foreach ($result as $index => $row) {
		        if (empty($row['parentid'])) {
		            $reply[$row['id']] = $row;
		        } else {
		            $reply[$row['parentid']]['children'][] = $row;
		        }
		    }
		}
		include template('modules/news/display', TEMPLATE_INCLUDEPATH);
	}
	
	public function fieldsFormValidate($rid = 0) {
		return true;	
	}
	
	public function fieldsFormSubmit($rid = 0) {
		global $_GPC, $_W;
		if (!empty($_GPC['news-title'])) {
		    foreach ($_GPC['news-title'] as $index => $title) {
		        if (empty($title)) {
		            continue;
		        }
		        $update = array(
	                'title' => $title,
	                'description' => $_GPC['news-description'][$index],
	                'thumb' => $_GPC['news-picture-old'][$index],
	                'content' => $_GPC['news-content'][$index],
	                'url' => $_GPC['news-url'][$index],
		        );
		        if (!empty($_GPC['news-picture'][$index])) {
		            $update['thumb'] = $_GPC['news-picture'][$index];
		            file_delete($_GPC['news-picture-old'][$index]);
		        }
		        pdo_update($this->tablename, $update, array('id' => $index));
		        
		        if (!empty($_GPC['news-title-content-new'][$index])) {
		            foreach ($_GPC['news-title-content-new'][$index] as $k => $t) {
		            	if (empty($_GPC['news-title-content-new'][$index][$k])) {
		            		continue;
		            	}
		                $insert = array(
		                    'rid' => $rid,
		                    'parentid' => intval($index),
		                    'title' => $_GPC['news-title-content-new'][$index][$k],
		                    'description' => '',
		                    'thumb' => $_GPC['news-picture-content-new'][$index][$k],
		                    'content' => $_GPC['news-content-content-new'][$index][$k],
		                    'url' => $_GPC['news-url-content-new'][$index][$k],
		                );
		                pdo_insert($this->tablename, $insert);
		            }
		        }
		    } 
		}
		//处理添加
		if (!empty($_GPC['news-title-new'])) {
			foreach ($_GPC['news-title-new'] as $index => $title) {
				if (empty($title)) {
					continue;
				}
				$insert = array(
					'rid' => $rid,
				    'parentid' => 0,
					'title' => $title,
					'description' => $_GPC['news-description-new'][$index],
					'thumb' => $_GPC['news-picture-new'][$index],
					'content' => $_GPC['news-content-new'][$index],
					'url' => $_GPC['news-url-new'][$index],
				);
				pdo_insert($this->tablename, $insert);
				$newsParentid = pdo_insertid();
				
				if (!empty($_GPC['news-title-content-new'][$index])) {
				    foreach ($_GPC['news-title-content-new'][$index] as $k => $t) {
				        $insert = array(
    		                'rid' => $rid,
    		                'parentid' => intval($newsParentid),
    		                'title' => $_GPC['news-title-content-new'][$index][$k],
    		                'description' => '',
    		                'thumb' => $_GPC['news-picture-content-new'][$index][$k],
    		                'content' => $_GPC['news-content-content-new'][$index][$k],
    		                'url' => $_GPC['news-url-content-new'][$index][$k],
				        );
				        pdo_insert($this->tablename, $insert);
				    }
				}
			}
		}
		return true;	
	}
	
	public function ruleDeleted($rid = 0) {
		global $_W;
	    $replies = pdo_fetchall("SELECT id, thumb FROM ".tablename($this->tablename)." WHERE rid = '$rid'");
	    $deleteid = array();
	    if (!empty($replies)) {
	        foreach ($replies as $index => $row) {
	        	file_delete($row['thumb']);
	            $deleteid[] = $row['id'];        
	        }
	    }
	    pdo_delete($this->tablename, "id IN ('".implode("','", $deleteid)."')");  
	    return true;
	}
	
	public function doFormDisplay() {
		global $_W, $_GPC;
		$result = array('error' => 0, 'message' => '', 'content' => '');
		$result['content']['id'] = $GLOBALS['id'] = 'add-row-news-'.$_W['timestamp'];
		$result['content']['html'] = template('modules/news/'.$_GPC['tpl'].'_form_display', TEMPLATE_FETCH);
		exit(json_encode($result));
	}

	public function doDetail() {
		global $_W, $_GPC;
		$id = intval($_GPC['id']);
		$sql = "SELECT * FROM " . tablename($this->tablename) . " WHERE `id`=:id";
		$row = pdo_fetch($sql, array(':id'=>$id));
		if (!empty($row['url'])) {
			header("Location: ".$row['url']);
		}
		$row = istripslashes($row);
		$row['thumb'] = $_W['attachurl'] . trim($row['thumb'], '/');
		include template('modules/news/detail', TEMPLATE_INCLUDEPATH);
	}
	
	public function doDelete() {
	    global $_W,$_GPC;
	    $id = intval($_GPC['id']);
	    $sql = "SELECT id, parentid, rid, thumb FROM " . tablename($this->tablename) . " WHERE `id`=:id";
	    $row = pdo_fetch($sql, array(':id'=>$id));
	    if (empty($row)) {
	        message('抱歉，回复不存在或是已经被删除！', '', 'error');
	    }
	    if (pdo_delete($this->tablename, array('id' => $id))) {
	    	file_delete($row['thumb']);
	        if ($row['parentid'] == 0) {
	        	$list = pdo_fetchall("SELECT thumb FROM " . tablename($this->tablename) . " WHERE `parentid`=:parentid", array(':parentid' => $row['id']));
	        	if (!empty($list)) {
	        		foreach ($list as $thumb) {
	        			file_delete($thumb['thumb']);
	        		}
	        	}
	        	pdo_delete($this->tablename, array('parentid' => $row['id']));
	        }
	    }
	    message('删除回复成功', '', 'success');
	}
}