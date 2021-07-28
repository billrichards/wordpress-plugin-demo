<?php
namespace SiteStats;

class SiteStats {

    protected $wpdb; /** @var \wpdb WordPress Database object */
    protected $html = ''; /** @var string Formatted html to output */

    /**
     * @param \wpdb $wpdb WordPress Database object
     */
    public function __construct(\wpdb $wpdb)
    {
        $this->wpdb = $wpdb;
    }

    /**
     * Calls $this->setHtml() and prints $this->html
     */
    public function siteStatsDemo(): void
    {
        $this->setHtml();
        echo $this->html;
    }

    private function setHtml(): void
    {
       
        // Initialize the return value, which will be an HTML list
        $this->html = '<a href="" id="site-stats-toggle">Show Site Stats Info</a><div id="site-stats-demo"><dl>';

        // Add post info to $this->html
        $this->addPostInfo();

        // Add user info to $this->html 
        $this->addUserInfo();

        // Add comment info to $this->html
        $this->addCommentInfo();

        // Add plugin information to $this->html
        $this->addPluginInfo();

        // Add theme info to $this->html 
        $this->addThemeInfo();

        // Add term info to $this->html 
        $this->addTermInfo();

        $this->html .=  '</dl></div>';

    }   

    /**
     * Adds post info to $this->html
     */
    private function addPostInfo(): void
    {
        // Get post information
        // Use array_filter() because we only want categories with post count greater than 0
        $posts = array_filter((array) \wp_count_posts());
        if (!empty($posts)) {
            $this->html .= '<dt>Posts:</dt>';
            foreach ($posts as $postType => $count) {
                    if ($postType === 'publish') {
                        $postType = 'published'; // We want the output to say 'published' not 'publish
                    }
                    $this->html .= '<dd>';
                    $this->html .=sprintf( _n( "%s $postType post", "%s $postType posts", $count), number_format_i18n( $count ));
                    $this->html .= '</dd>';
                }
        } else {
            $this->html .= '<dt>Posts: 0</dt>';
        }
    }

    /**
     * Adds user info to $this->html
     */
    private function addUserInfo(): void 
    {
        // Get number of users
        $users = \count_users();
        $this->html .= "<dt>Users ({$users['total_users']} total):</dt>";
        foreach ($users as $key => $userInfo) {
            // Output detail for user types with count greater than 0
            if ($userInfo == 0) {
                continue;
            }
            if ($key === 'total_users') {
                continue;
            }
            if (is_array($userInfo)) {
                foreach ($userInfo as $idx => $count) {
                    if ($count == 0) { 
                        continue;
                    }
                    $this->html .= '<dd>';
                    $this->html .= sprintf( _n( "%s $idx user", "%s $idx users", $count), number_format_i18n( $count ));
                    $this->html .= '</dd>';
                }
            } else {
                $this->html .= '<dd>';
                $this->html .= sprintf( _n( "%s $key user", "%s $key users", $userInfo), number_format_i18n( $userInfo ));
                $this->html .= '</dd>';
            }
        }
    }

    /**
     * Adds comment info to $this->html
     */
    private function addCommentInfo(): void 
    {
        // Get number of comments and detail
        $comments = (array) \wp_count_comments();
        $this->html .= "<dt>Comments ({$comments['total_comments']} total):</dt>";
        $comments = array_filter($comments);    // We only want to output detail for comment types with count greater than 0
        if (!empty($comments)) {
            foreach ($comments as $commentType => $count) {
                    if (in_array($commentType, ['all','total_comments'])) {
                        continue; // We already output the total_comments, and we do not want to output 'all'
                    }
                    $this->html .= '<dd>';
                    $this->html .= sprintf( _n( "%s $commentType comment", "%s $commentType comments", $count), number_format_i18n( $count ));
                    $this->html .= '</dd>';
                }
        }
    }

    /**
     * Adds plugin info to $this->html
     */
    private function addPluginInfo(): void 
    {
        // Get plugin detail
        $plugins = \get_plugins();
        $pluginCount = count($plugins);
        $this->html .= '<dt>';
        $this->html .= sprintf( _n( "%s plugin installed:", "%s plugins installed:", $pluginCount), number_format_i18n( $pluginCount ));
        $this->html .= '</dt>';
        $this->html .= '<dd>';
        $this->html .= implode(', ', array_map( function($plugin) {return $plugin['Name']; }, $plugins));
        $this->html .= '</dd>';
    }

    /**
     * Adds theme info to $this->html 
     */
    private function addThemeInfo(): void 
    {
        // Get theme detail
        $themes = \wp_get_themes();
        $themeCount = count($themes);
        $this->html .= '<dt>';
        $this->html .= sprintf( _n( "%s theme installed:", "%s themes installed:", $themeCount), number_format_i18n( $themeCount ));
        $this->html .= '</dt>';
        $this->html .= '<dd>';
        $this->html .= implode(', ', array_keys($themes));
        $this->html .= '</dd>';
    }

    /**
     * Adds term info to $this->html 
     */
    private function addTermInfo(): void 
    {
        // Get information about wp_terms (just to demo using the $wpdb object)
        $terms = $this->wpdb->get_results( "SELECT `name` FROM `wp_terms`" );
        $termCount = count($terms);
        $this->html .= '<dt>';
        $this->html .= sprintf( _n( "%s term:", "%s terms:", $termCount), number_format_i18n( $termCount ));
        $this->html .= '</dt>';
        $this->html .= '<dd>';
        $this->html .= implode(', ', array_map( function($row) {return $row->name; }, $terms));
        $this->html .= '</dd>';
    }

}