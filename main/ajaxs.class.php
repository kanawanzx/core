<?php

class AS_AJAXS extends AS_MAIN {

    public function as_init()
    {
        $this->as_add_ajax('as_like_post', 'as_like_post');
        $this->as_add_ajax('as_load_project', 'as_load_project');
    }

    public function as_like_post()
    {
        $data   = $_REQUEST['content'];
        $count  = get_post_meta($data['id'], 'as_like_count', true);
        $count++;
        $result = update_post_meta($data['id'], 'as_like_count', $count);
        if (!is_wp_error($result))
        {
            $response = array(
                'success' => true,
                'count'   => get_post_meta($data['id'], 'as_like_count', true),
            );
        }
        else
        {
            $response = array(
                'success' => false,
                'count'   => 0,
            );
        }
        wp_send_json($response);
    }

    public function as_load_project()
    {
        $data                     = $_REQUEST['content'];
        $project                  = get_post($data['id']);
        $project_permalink        = get_permalink($project->ID);
        $project_url              = get_post_meta($project->ID, 'dslc_project_url', true);
        $project_url_text         = get_post_meta($project->ID, 'dslc_project_url_text', true);
        $project_name             = get_post_meta($project->ID, 'dslc_project_name', true);
        $cats                     = array();
        $as_project_ajax_client   = '';
        $as_project_ajax_category = '';
        $as_project_ajax_social   = '';
        $terms                    = get_the_terms($project->ID, 'dslc_projects_cats');
        if (!empty($terms))
        {
            foreach ($terms as $term)
            {
                $cats[] = $term->name;
            }
        }
        $dslc_projects_cats = join(', ', $cats);

        $post_img       = wp_get_attachment_url(get_post_thumbnail_id($project->ID));
        $share_status   = get_the_title($project->ID);
        $excerpt_status = get_the_excerpt($project->ID);

        $fb_share = '<li><a href="#" target="_blank" onClick="return dslc_social_share(400, 300, \'http://www.facebook.com/share.php?u=' . $project_permalink . '\')" class="as-facebook"><span class="dslc-icon dslc-icon-facebook"></span></a></li>';

        $twitter_share = '<li><a href="#" onClick="return dslc_social_share(400, 300, \'https://twitter.com/home?status=' . $project_permalink . '\')" class="as-twitter"><span class="dslc-icon dslc-icon-twitter"></span></a></li>';

        $google_share = '<li><a href="https://plus.google.com/share?url=' . $project_permalink . '&amp;title=' . $share_status . '" onclick="javascript:window.open(this.href,\'\', \'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=400,width=500\');return false;" class="as-google-plus"><span class="dslc-icon dslc-icon-google-plus"></span></a></li>';

        $pinterest_share = '<li><a href="#" onClick="return dslc_social_share(400, 300, \'https://pinterest.com/pin/create/button/?url=' . $project_permalink . '&amp;media=' . esc_html($post_img) . '&amp;description=' . $share_status . '\')"  class="as-pinterest"><span class="dslc-icon dslc-icon-pinterest"></span></a></li>';


        $btn_get = '<a href="' . $project_url . '" class="as-get-in-touch-prj-ajax">' . __('Visit Project', 'alenastudio') . '</a>';
        // control option project
        if (as_option('as_port_post_info_client', '1'))
        {
            $as_project_ajax_client .= '<div class="as-info-client">
                                        <span class="dslc-icon dslc-icon-user"></span>&nbsp;&nbsp;<span class="as-info-sum">Client:</span>&nbsp; <span>' . $project_name . '</span>
                                    </div>';
        }
        if (as_option('as_port_post_info_url', '1'))
        {
            $as_project_ajax_client .= '<div class="as-info-url">				
                                     <span class="dslc-icon dslc-icon-link"></span>&nbsp;&nbsp;<span class="as-info-sum">URL Project:</span>&nbsp; <a href="' . $project_url . '" target="_blank">' . $project_url_text . '</a>
                                    </div>';
        }
        if (as_option('as_port_post_info_categories', '1'))
        {
            $as_project_ajax_category = '<span class="as-port-ajax-category">' . $dslc_projects_cats . '</span>';
        }
        if (as_option('as_port_btn_list_share_social', '1'))
        {
            $as_project_ajax_social .='<ul class="as-port-ajax-list-social">
									' . $fb_share . '
									' . $twitter_share . '
									' . $google_share . '
									' . $pinterest_share . '
								</ul>';
        }
        $html     = '<div class="as-mask-color-port">
					<svg class="as-preloading-port" width="80" height="80" viewbox="0 0 80 80">
	                    <polygon points="0 0 0 80 80 80 80 0" class="rect" />
	                </svg>
				</div>
				<div class="as-title-port-ajax-wrapper dslc-col dslc-12-col dslc-last-col">
					<h1 class="as-port-ajax-title">' . $project->post_title . '</h1>
					' . $as_project_ajax_category . '
				</div>
				<div class="as-port-ajax-data">
					<div class="dslc-col dslc-6-col port-thumb">
						<div class="as-port-ajax-thumbnail-img">
							' . get_the_post_thumbnail($project->ID, 'full') . '
						</div>
					</div>
					<div class="dslc-col dslc-6-col dslc-last-col as-port-ajax-excerpt">
						<div class="as-ajax-info-wrapper">
							' . apply_filters('the_content', $project->post_content) . '
							<div class="clearfix"></div>
							<div class="as-info-project-meta">
                                 ' . $as_project_ajax_client . '
							</div>
							<div class="as-port-ajax-social-share">
								' . $btn_get . '
								' . $as_project_ajax_social . '
							</div>
							<div class="clearfix"></div>
						</div>
					</div>
				</div>
				<div class="clearfix"></div>';
        $response = array(
            'success'   => true,
            'html'      => $html,
            'prev_post' => as_get_next_previous_port_id($project->ID, 'next'),
            'next_post' => as_get_next_previous_port_id($project->ID, 'prev'),
        );
        wp_send_json($response);
    }

}
