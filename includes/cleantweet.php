<?php

function cleanTweet($stat) {
    $stat = preg_replace('{(.)\1+}','$1',$stat);
    
    $stat = trim($stat);    
    $stat = html_entity_decode($stat, ENT_QUOTES, 'UTF-8');  
    $stat = preg_replace("#([A-Za-z][A-Za-z0-9+.-]{1,120}:[A-Za-z0-9/](([A-Za-z0-9\$_.+!*,;/?:@&~=-])|%[A-Fa-f0-9]{2}){1,333}(\#([a-zA-Z0-9][a-zA-Z0-9\$_.+!*,;/?:@&~=%-]{0,1000}))?)#is", '...', $stat);
    $stat = stripslashes($stat);     
    
    $stat = preg_replace('{(.)\1+}','$1',$stat);
    
    $naughty = array('vagina', 'bob', 'dildo', 'fuck', 'shit', 'pis', 'cunt', 'tits', 'ashole', 'ases', 'ass', 'niple', 'tities', 'tity', 'cock', 'fagot', 'penis', 'horny', 'niga', 'niger', 'sex', 'hardcore', 'bals', 'fuk', 'dong', 'proxy', 'sms.ub3rk1ten.com', 'p3n1s', '&shy;', '.com', '.net', 'gay', 'gays', 'gayz' );
    foreach ($naughty as $word) {
        $replacement = substr($word, 0, 1) . @str_repeat('*', strlen($word) + rand(-3,1)) . substr($word, strlen($word) - 1);
        $stat = str_ireplace($word, $replacement, $stat);
    }            
       
    return $stat;                                
}

?>