<?php
defined('IN_IA') or exit('Access Denied');

class LoveModuleProcessor extends WeModuleProcessor {
    
    public $name = 'Love';

    public function isNeedInitContext() {
        return 0;
    }

    public function respond() {
        $reply = '';
        $inContext = WeUtility::inContext();
        if(!$inContext) {
            $content = trim($this->message['content']);
            if($content == '2') {
                WeUtility::beginContext();
                WeUtility::setContext('do', 'profile');
            }
            if($content == '3') {
                $reply = $this->display();
            }
            if($content == '0' || $content == '1') {
                WeUtility::beginContext();
                WeUtility::setContext('do', 'query');
                WeUtility::setContext('filter-gender', $this->message['content']);
            }
        }
        if(empty($reply)) {
            $do = WeUtility::getContext('do');
            if($do == 'query') {
                $reply = $this->query();
            }
            if($do == 'profile') {
                $reply = $this->profile();
            }
        }
        if(empty($reply)) {
            $reply = "您的回复不正确 \n注册或修改个人信息请回复 2 \n查看个人信息请回复 3 \n找女友请回复 0 \n找男友请回复 1";
        }
        $r = array();
        $r['from'] = $this->message['to'];
        $r['to'] = $this->message['from'];
        $r['time'] = TIMESTAMP;
        $r['type'] = 'text';
        $r['content'] = $reply;
        WeUtility::logging('debug', $_SESSION);
        return $r;
    }

    private function display() {
        $sql = "SELECT * FROM " . tablename('love_members') . " WHERE `original`=:original LIMIT 1";
        $profile = pdo_fetch($sql, array(':original' => $this->message['from']));
        $reply = '';
        if(empty($profile)) {
            $reply .= '您还没有提交个人信息, 请输入 2 提交个人信息. ';
        } else {
            $profile['gender'] = $profile['gender'] ? '男' : '女';
            $profile['wish'] = $profile['wish'] ? '男' : '女';
            $reply .= "微信号: {$profile['wechat']}\n";
            $reply .= "昵称: {$profile['username']}\n";
            $reply .= "城市: {$profile['district']}\n";
            $reply .= "性别: {$profile['gender']}\n";
            $reply .= "年龄: {$profile['age']}\n";
            $reply .= "交友倾向: {$profile['wish']}\n";
            $reply .= "个人简介: {$profile['introduce']}";
        }
        return $reply;
    }

    private function profile() {
        $sql = "SELECT * FROM " . tablename('love_members') . " WHERE `original`=:original LIMIT 1";
        $profile = pdo_fetch($sql, array(':original' => $this->message['from']));
        $extra = '';
        $content = trim($this->message['content']);
        if(WeUtility::getContext('do-step') == 'wechat') {
            if(!empty($profile) && $content == '.') {
                $wechat = $profile['wechat'];
            } else {
                $wechat = $this->input('wechat', $extra);
            }
            if(!empty($wechat)) {
                WeUtility::setContext('item-wechat', $wechat);
                WeUtility::setContext('do-step', null);
            }
        }
        if(WeUtility::getContext('do-step') == 'username') {
            if(!empty($profile) && $content == '.') {
                $username = $profile['username'];
            } else {
                $username = $this->input('username', $extra);
            }
            if(!empty($username)) {
                WeUtility::setContext('item-username', $username);
                WeUtility::setContext('do-step', null);
            }
        }
        if(WeUtility::getContext('do-step') == 'gender') {
            if(!empty($profile) && $content == '.') {
                $gender = $profile['gender'];
            } else {
                $gender = $this->input('gender', $extra);
            }
            if(isset($gender)) {
                WeUtility::setContext('item-gender', $gender);
                WeUtility::setContext('do-step', null);
            }
        }
        if(WeUtility::getContext('do-step') == 'city') {
            if(!empty($profile) && $content == '.') {
                $city = $profile['district'];
            } else {
                $city = $this->input('city', $extra);
            }
            if(!empty($city) && $city != 'all') {
                WeUtility::setContext('item-city', $city);
                WeUtility::setContext('do-step', null);
            }
        }
        if(WeUtility::getContext('do-step') == 'birthday') {
            if(!empty($profile) && $content == '.') {
                $birthday = $profile['birthday'];
            } else {
                $birthday = $this->input('birthday', $extra);
            }
            if(!empty($birthday)) {
                WeUtility::setContext('item-birthday', $birthday);
                WeUtility::setContext('do-step', null);
            }
        }
        if(WeUtility::getContext('do-step') == 'introduce') {
            if(!empty($profile) && $content == '.') {
                $introduce = $profile['introduce'];
            } else {
                $introduce = $this->input('introduce', $extra);
            }
            if(!empty($introduce)) {
                WeUtility::setContext('item-introduce', $introduce);
                WeUtility::setContext('do-step', null);
            }
        }
        if(WeUtility::getContext('do-step') == 'wish') {
            if(!empty($profile) && $content == '.') {
                $wish = $profile['wish'];
            } else {
                $wish = $this->input('wish', $extra);
            }
            if(isset($wish)) {
                WeUtility::setContext('item-wish', $wish);
                WeUtility::setContext('do-step', null);
            }
        }
        $item = array();
        $item['wechat'] = WeUtility::getContext('item-wechat');
        $item['username'] = WeUtility::getContext('item-username');
        $item['gender'] = WeUtility::getContext('item-gender');
        $item['city'] = WeUtility::getContext('item-city');
        $item['birthday'] = WeUtility::getContext('item-birthday');
        $item['introduce'] = WeUtility::getContext('item-introduce');
        $item['wish'] = WeUtility::getContext('item-wish');
        $isOk = true;
        foreach($item as $v) {
            if(!isset($v)) {
                $isOk = false;
                break;
            }
        }
        if(!$isOk) {
            $reply = "您正在" . (empty($profile) ? '提交' : '编辑') . "您的个人资料. \n";
            if(!empty($extra)) {
                $extra .= "请重新";
            } else {
                $extra = "请";
            }
            if(empty($item['wechat'])) {
                if(!empty($profile)) {
                    $reply .= "您当前的微信账号是: {$profile['wechat']}. 如果保持当前请输入点号(.) 如果要更改请重新提交. \n";
                }
                $reply .= "{$extra}提交您的微信账号. ";
                WeUtility::setContext('do-step', 'wechat');
            } elseif (empty($item['username'])) {
                if(!empty($profile)) {
                    $reply .= "您当前的昵称是: {$profile['username']}. 如果保持当前请输入点号(.) 如果要更改请重新提交. \n";
                }
                $reply .= "{$extra}提交您的昵称. ";
                WeUtility::setContext('do-step', 'username');
            } elseif (!isset($item['gender'])) {
                if(!empty($profile)) {
                    $reply .= "您当前的性别是: " . ($profile['gender'] ? '男' : '女') . ". 如果保持当前请输入点号(.) 如果要更改请重新提交. \n";
                }
                $reply .= "{$extra}提交您的性别(男或者女). ";
                WeUtility::setContext('do-step', 'gender');
            } elseif (empty($item['city'])) {
                if(!empty($profile)) {
                    $reply .= "您当前所在的城市是: {$profile['district']}. 如果保持当前请输入点号(.) 如果要更改请重新提交. \n";
                }
                $reply .= "{$extra}提交您所在的城市(必须是市级行政区, 比如北京市 济南市等, 县级行政区如海淀区 华阴县将不能接受). ";
                WeUtility::setContext('do-step', 'city');
            } elseif (empty($item['birthday'])) {
                if(!empty($profile)) {
                    $reply .= "您当前的出生日期是: {$profile['birthday']}. 如果保持当前请输入点号(.) 如果要更改请重新提交. \n";
                }
                $reply .= "{$extra}提交您的出生日期(格式如 1990-01-23. 如果要保护隐私可以只提供年份或年份月份, 如 1990  1989-06). ";
                WeUtility::setContext('do-step', 'birthday');
            } elseif (empty($item['introduce'])) {
                if(!empty($profile)) {
                    $reply .= "您当前的交友宣言是: \n{$profile['introduce']}. \n如果保持当前请输入点号(.) 如果要更改请重新提交. \n";
                }
                $reply .= "{$extra}提交您的交友宣言(最能突出您个性的一句话噢). ";
                WeUtility::setContext('do-step', 'introduce');
            } elseif (!isset($item['wish'])) {
                if(!empty($profile)) {
                    $reply .= "您当前的交友倾向是: " . ($profile['wish'] ? '男' : '女') . ". 如果保持当前请输入点号(.) 如果要更改请重新提交. \n";
                }
                $reply .= "{$extra}提交您的交友倾向(找男友请回复 1, 找女友请回复 0). ";
                WeUtility::setContext('do-step', 'wish');
            }
        } else {
            WeUtility::endContext();
            $row = array_elements(array('wechat', 'username', 'gender', 'birthday', 'introduce', 'wish'), $item);
            $row['district'] = $item['city'];
            $year = substr($row['birthday'], 0, 4);
            $row['age'] = intval(date('Y') - intval($year));
            if(empty($profile)) {
                $row['original'] = $this->message['from'];
                pdo_insert('love_members', $row);
                $reply = '您已经提交资料成功. ';
            } else {
                pdo_update('love_members', $row, array('original' => $this->message['from']));
                $reply = '您已经修改资料成功. ';
            }
            $filter = array();
            $filter['city'] = $row['district'];
            $filter['gender'] = $row['wish'];
            $match = $this->match($filter);
            if(!empty($match)) {
                $reply .= "根据您的资料, 我们已经为您找到了合适的交友对象. \n";
                $reply .= $match;
            } else {
                $reply .= "接下来你可以查找匹配的好友了. 找男友请回复 1, 找女友请回复 0";
            }
        }
        return $reply;
    }

    private function query() {
        $extra = '';
        if(WeUtility::getContext('do-step') == 'city') {
            $city = $this->input('city', $extra);
            if(!empty($city)) {
                WeUtility::setContext('filter-city', $city);
                WeUtility::setContext('do-step', null);
            }
        }
        if(WeUtility::getContext('do-step') == 'age') {
            $range = $this->input('age-range', $extra);
            if(!empty($range)) {
                WeUtility::setContext('filter-age', $range);
                WeUtility::setContext('do-step', null);
            }
        }
        $filter = array();
        $filter['city'] = WeUtility::getContext('filter-city');
        $filter['age'] = WeUtility::getContext('filter-age');
        $filter['gender'] = WeUtility::getContext('filter-gender');
        if(empty($filter['city']) || empty($filter['age'])) {
            $reply = "您想要";
            if(!empty($filter['city'])) {
                $reply .= "在城市(" .($filter['city'] == 'all' ? '所有城市' : $filter['city']) . ")中";
            }
            $reply .= "查找";
            if(!empty($filter['age'])) {
                $reply .= "年龄在{$filter['age']}之间的";
            }
            $reply .= $filter['gender'] == '1' ? '男朋友' : '女朋友. ';
            if(empty($filter['city'])) {
                if(empty($extra)) {
                    $reply .= "\n请输入要查找的好友所在的城市. 如果不限城市请输入: 全部";
                } else {
                    $reply .= "\n{$extra}请重新输入要查找的好友所在的城市. 如果不限城市请输入: 全部";
                }
                WeUtility::setContext('do-step', 'city');
            } elseif (empty($filter['age'])) {
                if(empty($extra)) { 
                    $reply .= "\n请输入要查找的好友的年龄范围, 如: 18-23";
                } else {
                    $reply .= "\n{$extra}请重新输入要查找的好友的年龄范围, 如: 18-23";
                }
                WeUtility::setContext('do-step', 'age');
            }
        } else {
            WeUtility::endContext();
            $match = $this->match($filter);
            if(!empty($match)) {
                $reply = "已经为您查找到符合的数据: \n{$match}";
            } else {
                $reply = '当前城市还没有任何数据, 欢迎提交信息. ';
            }
        }
        return $reply;
    }

    private function match($filter) {
        $params = array();
        $params[':gender'] = intval($filter['gender']);
        $piece = '';
        if(!empty($filter['age'])) {
            $piece = ' AND `age` BETWEEN :begin AND :end';
            $betw = explode('-', $filter['age']);
            $params[':begin'] = $betw[0];
            $params[':end'] = $betw[1];
        }
        if(!empty($filter['city']) && $filter['city'] != 'all') {
            $piece = ' AND `district`=:district';
            $params[':district'] = $filter['city'];
        }
        $sql = "SELECT * FROM " . tablename('love_members') . " WHERE `gender`=:gender{$piece} ORDER BY RAND() LIMIT 1";               
        $row = pdo_fetch($sql, $params);
        $reply = '';
        if(!empty($row)) {
            $row['gender'] = $row['gender'] ? '男' : '女';
            $reply .= "微信号: {$row['wechat']}\n";
            $reply .= "昵称: {$row['username']}\n";
            $reply .= "城市: {$row['district']}\n";
            $reply .= "性别: {$row['gender']}\n";
            $reply .= "年龄: {$row['age']}\n";
            $reply .= "个人简介: {$row['introduce']}";
        }
        return $reply;
    }

    private function input($field, &$error = null) {
        $r = null;
        $content = trim($this->message['content']);
        switch($field) {
            case 'wechat':
                $regex = '/^[a-z\d_\-]{6,20}$/i';
                if(preg_match($regex, $content)) {
                    $r = $content;
                } else {
                    $error = "您输入的微信账号格式不正确, 只能包含字母, 数字, 减号(-), 下划线(_). ";
                }
                break;
            case 'city':
                if($content == '全部') {
                    $r = 'all';
                } else {
                    $sql = "SELECT * FROM " . tablename('love_cities') . " WHERE `title` LIKE :title LIMIT 1";
                    $row = pdo_fetch($sql, array(':title'=>$content . '%'));
                    if(empty($row)) {
                        $error = '您输入的城市不正确, 请精确到市级行政区. ';
                    } else {
                        $r = $row['title'];
                    }
                }
                break;
            case 'username':
                $regex = '/^[\x{4e00}-\x{9fa5}a-z\d_\-]{2,10}$/iu';
                if(preg_match($regex, $content)) {
                    $r = $content;
                } else {
                    $error = "您输入的昵称格式不正确, 只能包含汉字, 字母, 数字, 减号(-), 下划线(_). ";
                }
                break;
            case 'gender':
                $r = $content == '男' ? 1 : 0;
                break;
            case 'birthday':
                $regex = '/(?P<year>\d{4})[^\d]*(?P<month>\d{0,2})[^\d]*(?P<day>\d{0,2})/i';
                $match = null;
                if(preg_match($regex, $content, $match)) {
                    $year = $match['year'];
                    $month = $match['month'] ? $match['month'] : '1';
                    $day = $match['day'] ? $match['day'] : '1';
                    if(!checkdate($month, $day, $year)) {
                        $error = '您输入的生日日期不合法. ';
                    } else {
                        $r = "{$year}-{$month}-{$day}";
                    }
                } else {
                    $error = "您输入的生日格式不正确. ";
                }
                break;
            case 'age-range':
                $regex = '/(?P<begin>\d+)[^\d]+(?P<end>\d+)/i';
                $match = null;
                if(preg_match($regex, $content, $match)) {
                    $begin = intval($match['begin']);
                    $end = intval($match['end']);
                    if($begin > $end || $begin < 16 || $end > 50) {
                        $error = '您输入的年龄范围不能接受, 最小交友年龄 16, 最大交友年龄 50. ';
                    } else {
                        $r = "{$begin}-{$end}";
                    }
                } else {
                    $error = "您输入的年龄范围格式错误. ";
                }
                break;
            case 'introduce':
                $r = $content;
                break;
            case 'wish':
                $r = $content == '1' ? 1 : 0;
                break;
        }
        return $r;
    }

    public function isNeedSaveContext() {
        return false;
    }
}
