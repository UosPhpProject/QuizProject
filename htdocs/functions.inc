<?PHP
  #------- homepage �̻����� üũ http://www.zend.com ���� ----------#
  function is_url_valid( $url )
  {
    if ( eregi( "[a-z0-9]+\.[a-z0-9_]+", $url ) )
      return TRUE;
    else
      return FALSE;
  }


  #---------- email �̻����� üũ http://www.zend.com ���� ----------#
  function is_email_valid( $email ) 
  { 
    if( eregi( "^[a-z0-9\._-]+@[a-z0-9\._-]+\.[a-z]+", $email ) ) 
      return TRUE; 
    else 
      return FALSE; 
  }
  
  #------------------ error ó�� �Լ� --------------------#
  function error( $msg )
  {
    echo("
    <script language=\"javascript\">
      alert( \"$msg\" );
      history.back();
    </script>" );
  }
  
  #---------------- forwarding ó�� �Լ� ------------------#
  function forward( $url )
  {
    header( "Location:".$url );
    //echo( "<meta http-equiv='Refresh' content='0'; URL=list.html" );
  }

  #--------------- ��ũ�� ����� �ִ� �Լ� ------------------#
  function dest_url( $link, $page, $uid=NULL )
  {
      GLOBAL $kind;
      GLOBAL $key;

      $link .= "?page=$page";
      if ( $uid )
        $link .= "&uid=$uid";
      if ( $key )
        $link .= "&kind=$kind&key=$key";
      return $link;
  }

?>