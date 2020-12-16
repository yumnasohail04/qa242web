BEGIN
    select * from
    (
    SELECT distinct  `1aa`.assignment_id `assign_id`
         ,  `1aa`.assign_ans_id
         ,  CAST(asign.approval_datetime AS date) `Date`
         ,  CAST(asign.approval_datetime AS TIME) `Time`
         ,  `1aa`.shift_no AS `Shift`
         ,  `1cq`.question_id
         ,  `1cq`.question
         ,  'assignments/pending_review_detail' `unique_url`
         ,  `asign`.approval_datetime `approval_datetime`
         ,  CASE
#                 WHEN `1aa`.given_answer = '' THEN '-'
                WHEN `1aa`.comments <> '' THEN `1aa`.comments
                ELSE `1aa`.given_answer
            END `Answer`
         ,  `1l`.line_name `Line`
         ,  `1p`.plant_name `Plant`
         ,  CONCAT(u.first_name , ' ', u.last_name) `User`
         ,  `1aa`.user_id
#          , case
#              when
#              exists (
#                  select * from `1_assignment_answer` `1aa_in`
#                  where `1aa_in`.assignment_id = asign.assign_id and LENGTH(if(ISNULL(`1aa_in`.comments), "", `1aa_in`.comments)) > 0
#                    AND (DATEDIFF(CAST( asign.start_datetime AS DATE) , CAST( p_date_from  AS DATE)) >= 0
#                      AND DATEDIFF(CAST(p_date_to  AS DATE) , CAST( asign.end_datetime AS DATE)) >= 0
#                      )
#                  )
#              then 'Failed'
#              else 'Passed'
#            end
         , asign.pf_status `Status`
         , `1pc`.checkname
         ,  prod.product_title
         ,  `1aa`.given_answer
         ,  `1aa`.comments
#          ,  (
#                 SELECT GROUP_CONCAT(`1pt`.name)
#                 FROM `1_assignment_programs` `1ap_in`
#                 LEFT JOIN  `1_program_types` `1pt` on `1ap_in`.ap_program = `1pt`.id
#                 WHERE `1ap_in`.ap_assignment = asign.assign_id
#                 AND (p_program_types = 0 or `1ap`.ap_program = 1 or `1ap`.ap_program = p_program_types)
#             )
        ,   1pt.name `Program Types`
        ,   inspectors.group_title as `inspection_team`
        ,   reviwers.group_title as `review_team`
        ,   approvers.group_title as `approval_team`
        ,   `1pc`.dashboard_circle_id
    FROM `1_assignments` asign
    LEFT JOIN  `1_assignment_answer` `1aa` on `1aa`.assignment_id = asign.assign_id
    LEFT JOIN  `1_product_checks` `1pc` on asign.checkid = `1pc`.id
    LEFT JOIN  `1_checks_questions` `1cq` on `1aa`.question_id = `1cq`.question_id
    LEFT JOIN  `1_product` prod on asign.product_id = prod.id
    LEFT JOIN  `users` u on `1aa`.user_id = u.id
    LEFT JOIN  `1_plants` `1p` on  asign.plant_no = `1p`.plant_id #`1aa`.plant_id = `1p`.plant_id
    LEFT JOIN  `1_lines` `1l` on `1aa`.line_no = `1l`.line_id
    LEFT JOIN    `1_groups` `inspectors` ON asign.inspection_team = `inspectors`.id
    LEFT JOIN   `1_groups` `reviwers` ON asign.review_team = `reviwers`.id
    LEFT JOIN   `1_groups` `approvers` ON asign.approval_team = `approvers`.id
    LEFT JOIN  `1_program_types` `1pt` on asign.program_type = `1pt`.id
#     LEFT JOIN   `1_assignment_programs` `1ap` on  asign.assign_id = `1ap`.ap_assignment
    where
        (p_check_id = 0 OR asign.checkid = p_check_id)
#       AND (p_line_id = 0 OR (LOCATE(CONCAT(',',p_line_id),asign.line_timing) > 0 OR LOCATE(CONCAT(p_line_id,','),asign.line_timing,1) = 1))
      AND (p_product_id = 0 OR prod.id = p_product_id)
      AND (p_Status = 0
        OR (p_Status = 1 AND asign.pf_status = 'pass')
        OR (p_Status = 2 AND asign.pf_status = 'fail')
        )
      AND asign.assign_status = 'Completed'
      AND (approval_datetime between p_date_from AND p_date_to)
      AND (p_program_types = 0 or asign.program_type = 1 or asign.program_type = p_program_types)
      AND (p_plant_id = 0 or asign.plant_no = p_plant_id)
      AND (p_line_id = 0 or asign.line_timing = p_line_id)
      AND (p_questions = '' OR (LOCATE(CONCAT(',',`1cq`.question_id),p_questions) > 0 OR LOCATE(CONCAT(`1cq`.question_id,','),p_questions,1) = 1))
      AND (p_check_type = '' or p_check_type = 'standard') 

    UNION ALL

    SELECT distinct  `1aa`.assignment_id `assign_id`
                  ,  `1aa`.assign_ans_id
                  ,  CAST(asign.approval_datetime AS date) `Date`
                  ,  CAST(asign.approval_datetime AS TIME) `Time`
                  ,  `1aa`.shift_no AS `Shift`
                  ,  `1cq`.sfq_id `question_id`
                  ,  `1cq`.sfq_question `question`
                  ,  'static_form/static_form_detail' `unique_url`
                  ,  `asign`.approval_datetime approval_datetime 
                  ,  CASE
#                          WHEN `1aa`.given_answer = '' THEN '-'
                         WHEN `1aa`.comments <> '' THEN `1aa`.comments
                         ELSE `1aa`.given_answer
                    END `Answer`
                  ,  `1l`.line_name `Line`
                  ,  `1p`.plant_name `Plant`
                  ,  CONCAT(u.first_name , ' ', u.last_name) `User`
                  ,  `1aa`.user_id
#          , case
#              when
#              exists (
#                  select * from `1_assignment_answer` `1aa_in`
#                  where `1aa_in`.assignment_id = asign.assign_id and LENGTH(if(ISNULL(`1aa_in`.comments), "", `1aa_in`.comments)) > 0
#                    AND (DATEDIFF(CAST( asign.start_datetime AS DATE) , CAST( p_date_from  AS DATE)) >= 0
#                      AND DATEDIFF(CAST(p_date_to  AS DATE) , CAST( asign.end_datetime AS DATE)) >= 0
#                      )
#                  )
#              then 'Failed'
#              else 'Passed'
#            end
                  , asign.pf_status `Status`
                  , `1pc`.sf_name `checkname`
                  ,  '' product_title
                  ,  `1aa`.given_answer
                  ,  `1aa`.comments
                 ,  (
                        SELECT GROUP_CONCAT(`1pt`.name)
                        FROM `1_static_program_type` `1ap_in`
                        LEFT JOIN  `1_program_types` `1pt` on `1ap_in`.spt_program_id = `1pt`.id
                        WHERE `1ap_in`.spt_check_id = 1pc.sf_id
                        AND (p_program_types = 0 or `1ap_in`.spt_program_id = 1 or `1ap_in`.spt_program_id = p_program_types)
                    ) `Program Types`
                  ,   inspectors.group_title as `inspection_team`
                  ,   reviwers.group_title as `review_team`
                  ,   approvers.group_title as `approval_team`
                  ,   0 dashboard_circle_id
    FROM `1_static_assignments` asign
             LEFT JOIN  `1_static_assignment_answer` `1aa` on `1aa`.assignment_id = asign.assign_id
             LEFT JOIN  `1_static_form` `1pc` on asign.check_id = `1pc`.sf_id
             LEFT JOIN  `1_static_form_question` `1cq` on `1aa`.question_id = `1cq`.sfq_id
             LEFT JOIN  `users` u on `1aa`.user_id = u.id
             LEFT JOIN  `1_plants` `1p` on  `1aa`.plant_id = `1p`.plant_id
             LEFT JOIN  `1_lines` `1l` on `1aa`.line_no = `1l`.line_id
             LEFT JOIN    `1_groups` `inspectors` ON asign.inspection_team = `inspectors`.id
             LEFT JOIN   `1_groups` `reviwers` ON asign.review_team = `reviwers`.id
             LEFT JOIN   `1_groups` `approvers` ON asign.approval_team = `approvers`.id
             LEFT JOIN  `1_static_program_type` `1pt` on 1pc.sf_id = `1pt`.spt_check_id
#     LEFT JOIN   `1_assignment_programs` `1ap` on  asign.assign_id = `1ap`.ap_assignment
    where
        (p_check_id = 0 OR asign.check_id = p_check_id)
#       AND (p_line_id = 0 OR (LOCATE(CONCAT(',',p_line_id),`1aa`.line_no) > 0 OR LOCATE(CONCAT(p_line_id,','),`1aa`.line_no,1) = 1))
#       AND (p_product_id = 0 OR prod.id = p_product_id)
            AND (p_Status = 0
            OR (p_Status = 1 AND asign.pf_status = 'pass')
            OR (p_Status = 2 AND asign.pf_status = 'fail')
            )
      AND asign.assign_status = 'Approved'
      AND (approval_datetime between p_date_from AND p_date_to)
      AND (p_program_types = 0 or `1pt`.spt_program_id = 1 or `1pt`.spt_program_id = p_program_types)
      AND (p_plant_id = 0 or `1aa`.plant_id = p_plant_id)
      AND (p_line_id = 0 or `1aa`.line_no = p_line_id)
      AND (p_questions = '' OR (LOCATE(CONCAT(',',`1cq`.sfq_id),p_questions) > 0 OR LOCATE(CONCAT(`1cq`.sfq_id,','),p_questions,1) = 1))
      AND (p_check_type = '' or p_check_type = 'static')
        ) asign
        ORDER BY asign.approval_datetime desc;
END