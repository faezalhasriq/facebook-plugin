<?php
require_once('include/api/SugarApi.php');

class CustomCasesFacebookApi extends SugarApi
{

    public function registerApiRest()
    {
        return array(
            'getCasesIdByFbIds' => array(
                'reqType' => 'POST',
                'path' => array('Cases', 'get_cases_by_facebook_ids'),
                'pathVars' => array('', ''),
                'method' => 'getCasesIdByFbIds',
                'shortHelp' => 'Get ids of existing cases related to facebook posts',
                'longHelp' => '',
            ),
            'getFbIdsByCase' => array(
                'reqType' => 'POST',
                'path' => array('Cases', 'get_facebook_id_by_case'),
                'pathVars' => array('', ''),
                'method' => 'getFbIdsByCase',
                'shortHelp' => 'Get facebok post ids that related to case',
                'longHelp' => '',
            ),
        );
    }
	
    public function getCasesIdByFbIds($api, $args)
    {
        $data = array();
		#error_log(print_r($args,1));
        if (isset($args['ids']) && !empty($args['ids'])) 
		{
            $db = DBManagerFactory::getInstance();
            foreach ($args['ids'] as $fb_id) 
			{
                $fb_id = $db->quote($fb_id); //Clean string
                $sql = "SELECT id FROM cases WHERE facebook_post_id = '$fb_id' AND deleted = 0 ";
				#error_log($sql);
                $case_id = $db->getOne($sql);

                if (!empty($case_id)) 
				{
                    $data[$fb_id] = $db->getOne($sql);
                }
            }
        }
		
        return $data;
    }
	
    public function getFbIdsByCase($api, $args)
    {
        $data = array(
            'success' => true,
            'error_msg' => '',
            'id' => '',
        );

        try 
		{
            if (isset($args['id']) && !empty($args['id'])) 
			{
                $db = DBManagerFactory::getInstance();

                $case_id = $db->quote($args['id']); //Clean string
                $sql = "SELECT facebook_post_id AS id FROM cases WHERE id = '$case_id' AND deleted = 0 ";
                $result = $db->query($sql);
				#error_log($sql);
                while ($row = $db->fetchByAssoc($result)) 
				{
                    $data['id'] = $row["id"];
                }
            }
        } 
		catch (Exception $exc) 
		{
            $data['success'] = false;
            $data['error_msg']   = $exc->getMessage();
        }
		
        return $data;
    }
}