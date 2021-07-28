<?php
namespace SiteStats;

class SiteStats {

    public static function siteStatsDemo()
    {
       echo self::getStats();
    }

    private static function getStats(): string
    {
        global $wpdb;
        // Start output buffering so we can use printf() to format our output
        $obLevel = ob_get_level(); // Checking the level will ensure that we call ob_end_clean() only for output buffering, and not any other output buffering that might be going on
        ob_start();
       
        // Initialize the return value, which will be an HTML list
        $html = '<dl>';

        // Get number of posts - total, published, draft
        // Use array_filter() because we only want categories with post count greater than 0
        $posts = array_filter((array) \wp_count_posts());
        if (!empty($posts)) {
            echo '<dt>Posts:</dt>';
            foreach ($posts as $postType => $count) {
                    if ($postType === 'publish') {
                        $postType = 'published'; // We want the output to say 'published' not 'publish
                    }
                    echo '<dd>';
                    printf( _n( "%s $postType post", "%s $postType posts", $count), number_format_i18n( $count ));
                    echo '</dd>';
                }
        } else {
            echo '<dt>Posts: 0</dt>';
        }

        // Get number of users
        $users = \count_users();
        echo "<dt>Users ({$users['total_users']} total):</dt>";
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
                    echo '<dd>';
                    printf( _n( "%s $idx user", "%s $idx users", $count), number_format_i18n( $count ));
                    echo '</dd>';
                }
            } else {
                echo '<dd>';
                printf( _n( "%s $key user", "%s $key users", $count), number_format_i18n( $userInfo ));
                echo '</dd>';
            }
        }

        // Get number of comments and detail
        $comments = (array) \wp_count_comments();
        echo "<dt>Comments ({$comments['total_comments']} total):</dt>";
        $comments = array_filter($comments);    // We only want to output detail for comment types with count greater than 0
        if (!empty($comments)) {
            foreach ($comments as $commentType => $count) {
                    if (in_array($commentType, ['all','total_comments'])) {
                        continue; // We already output the total_comments, and we do not want to output 'all'
                    }
                    echo '<dd>';
                    printf( _n( "%s $commentType comment", "%s $commentType comments", $count), number_format_i18n( $count ));
                    echo '</dd>';
                }
        }

        // Get plugin detail
        $plugins = \get_plugins();
        $pluginCount = count($plugins);
        echo '<dt>';
        printf( _n( "%s plugin installed:", "%s plugins installed:", $pluginCount), number_format_i18n( $pluginCount ));
        echo '</dt>';
        foreach ($plugins as $file => $pluginInfo) {
            echo "<dd>{$pluginInfo['Name']}</dd>";
        }

        // Get theme detail
        $themes = \wp_get_themes();
        $themeCount = count($themes);
        echo '<dt>';
        printf( _n( "%s theme installed:", "%s themes installed:", $themeCount), number_format_i18n( $themeCount ));
        echo '</dt>';
        foreach ($themes as $theme => $wpThemeObject) {
            echo "<dd>$theme</dd>";
        }

        // Get information about wp_terms (just to demo using the $wpdb object)
        $terms = $wpdb->get_results( "SELECT `name` FROM `wp_terms`" );
        $termCount = count($terms);
        echo '<dt>';
        printf( _n( "%s term defined:", "%s terms defined:", $termCount), number_format_i18n( $termCount ));
        echo '</dt>';
        foreach ($terms as $row) {
            echo "<dd>{$row->name}</dd>";
        }

        $html .= ob_get_contents() . '</dl>'; // Append the buffered output to the return value
        while (ob_get_level() > $obLevel) {
            ob_end_clean();
        }

        // Return the html string
        return $html;
    }   


}