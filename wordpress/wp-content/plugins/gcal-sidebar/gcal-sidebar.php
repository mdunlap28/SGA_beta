<?php
/*
Plugin Name: Gcal Sidebar
Plugin URI: http://www.oriontechnologysolutions.com/gcal-sidebar/
Description: Pulls a Google Calendar feed and displays it in your sidebar.
Version: 2.9
Author: Orion Technology Solutions
Author URI: http://www.oriontechnologysolutions.com
*/

/*  Copyright 2010  Orion Technology Solutions  (email : wordpress@oriontechnologysolutions.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

    Thank you Justin Bennett fr providing the initial foundation this was built from.
*/

function cmp($a, $b) {
    if($a['startTime'] > $b['startTime'])
        return 1;
    if($a['startTime'] == $b['startTime'])
        return 0;
    if($a['startTime'] < $b['startTime'])
        return -1;
}

class GcalSidebar extends WP_Widget {
    /** constructor */
    function GcalSidebar() {
        parent::WP_Widget(false, $name = 'GcalSidebar');
        add_shortcode('gcal-sidebar', array(&$this, 'shortcode'));
    }

    function shortcode($atts) {
        if(!isset($atts['feed_id']))
            return "feed_id must be set";
        if(!isset($atts['static_url_option']))
            $atts['static_url_option'] = 0;
        if(!isset($atts['title_url_option']))
            $atts['title_url_option'] = 0;
        $calGroup = $this->get_feed($atts);
        $title = $this->get_title($calGroup, $atts['title_url_option']);

        echo "<div class='gcal_sidebar'>";
        echo "<h2>" . $title . "</h2>";
        $this->display_feed($calGroup, $atts);
        echo "</div>";
    }
    /** @see WP_Widget::widget */
    function widget($args, $instance) {
        extract($args);

        $calGroup = $this->get_feed($instance);
        $title = $this->get_title($calGroup, $instance['title_url_option']);

        echo $before_widget;
        echo $before_title . $title . $after_title;

        $this->display_feed($calGroup, $instance);

        echo $after_widget;
    }

    /** @see WP_Widget::update */
    function update($new_instance, $old_instance) {
        return $new_instance;
    }

    /** @see WP_Widget::form */
    function form($instance) {
        $zonelist = array('' => 'Automatic',
                'Kwajalein' => '(GMT-12:00) International Date Line West',
		'Pacific/Midway' => '(GMT-11:00) Midway Island',
		'Pacific/Samoa' => '(GMT-11:00) Samoa',
		'Pacific/Honolulu' => '(GMT-10:00) Hawaii',
		'America/Anchorage' => '(GMT-09:00) Alaska',
		'America/Los_Angeles' => '(GMT-08:00) Pacific Time (US &amp; Canada)',
		'America/Tijuana' => '(GMT-08:00) Tijuana, Baja California',
		'America/Denver' => '(GMT-07:00) Mountain Time (US &amp; Canada)',
		'America/Chihuahua' => '(GMT-07:00) Chihuahua',
		'America/Mazatlan' => '(GMT-07:00) Mazatlan',
		'America/Phoenix' => '(GMT-07:00) Arizona',
		'America/Regina' => '(GMT-06:00) Saskatchewan',
		'America/Tegucigalpa' => '(GMT-06:00) Central America',
		'America/Chicago' => '(GMT-06:00) Central Time (US &amp; Canada)',
		'America/Mexico_City' => '(GMT-06:00) Mexico City',
		'America/Monterrey' => '(GMT-06:00) Monterrey',
		'America/New_York' => '(GMT-05:00) Eastern Time (US &amp; Canada)',
		'America/Bogota' => '(GMT-05:00) Bogota',
		'America/Lima' => '(GMT-05:00) Lima',
		'America/Rio_Branco' => '(GMT-05:00) Rio Branco',
		'America/Caracas' => '(GMT-04:30) Caracas',
		'America/Halifax' => '(GMT-04:00) Atlantic Time (Canada)',
		'America/Manaus' => '(GMT-04:00) Manaus',
		'America/Santiago' => '(GMT-04:00) Santiago',
		'America/La_Paz' => '(GMT-04:00) La Paz',
		'America/St_Johns' => '(GMT-03:30) Newfoundland',
		'America/Argentina/Buenos_Aires' => '(GMT-03:00) Georgetown',
		'America/Sao_Paulo' => '(GMT-03:00) Brasilia',
		'America/Godthab' => '(GMT-03:00) Greenland',
		'America/Montevideo' => '(GMT-03:00) Montevideo',
		'Atlantic/South_Georgia' => '(GMT-02:00) Mid-Atlantic',
		'Atlantic/Azores' => '(GMT-01:00) Azores',
		'Atlantic/Cape_Verde' => '(GMT-01:00) Cape Verde Is.',
		'Europe/Dublin' => '(GMT) Dublin',
		'Europe/Lisbon' => '(GMT) Lisbon',
		'Europe/London' => '(GMT) London',
		'Africa/Monrovia' => '(GMT) Monrovia',
		'Atlantic/Reykjavik' => '(GMT) Reykjavik',
		'Africa/Casablanca' => '(GMT) Casablanca',
		'Europe/Belgrade' => '(GMT+01:00) Belgrade',
		'Europe/Bratislava' => '(GMT+01:00) Bratislava',
		'Europe/Budapest' => '(GMT+01:00) Budapest',
		'Europe/Ljubljana' => '(GMT+01:00) Ljubljana',
		'Europe/Prague' => '(GMT+01:00) Prague',
		'Europe/Sarajevo' => '(GMT+01:00) Sarajevo',
		'Europe/Skopje' => '(GMT+01:00) Skopje',
		'Europe/Warsaw' => '(GMT+01:00) Warsaw',
		'Europe/Zagreb' => '(GMT+01:00) Zagreb',
		'Europe/Brussels' => '(GMT+01:00) Brussels',
		'Europe/Copenhagen' => '(GMT+01:00) Copenhagen',
		'Europe/Madrid' => '(GMT+01:00) Madrid',
		'Europe/Paris' => '(GMT+01:00) Paris',
		'Africa/Algiers' => '(GMT+01:00) West Central Africa',
		'Europe/Amsterdam' => '(GMT+01:00) Amsterdam',
		'Europe/Berlin' => '(GMT+01:00) Berlin',
		'Europe/Rome' => '(GMT+01:00) Rome',
		'Europe/Stockholm' => '(GMT+01:00) Stockholm',
		'Europe/Vienna' => '(GMT+01:00) Vienna',
		'Europe/Minsk' => '(GMT+02:00) Minsk',
		'Africa/Cairo' => '(GMT+02:00) Cairo',
		'Europe/Helsinki' => '(GMT+02:00) Helsinki',
		'Europe/Riga' => '(GMT+02:00) Riga',
		'Europe/Sofia' => '(GMT+02:00) Sofia',
		'Europe/Tallinn' => '(GMT+02:00) Tallinn',
		'Europe/Vilnius' => '(GMT+02:00) Vilnius',
		'Europe/Athens' => '(GMT+02:00) Athens',
		'Europe/Bucharest' => '(GMT+02:00) Bucharest',
		'Europe/Istanbul' => '(GMT+02:00) Istanbul',
		'Asia/Jerusalem' => '(GMT+02:00) Jerusalem',
		'Asia/Amman' => '(GMT+02:00) Amman',
		'Asia/Beirut' => '(GMT+02:00) Beirut',
		'Africa/Windhoek' => '(GMT+02:00) Windhoek',
		'Africa/Harare' => '(GMT+02:00) Harare',
		'Asia/Kuwait' => '(GMT+03:00) Kuwait',
		'Asia/Riyadh' => '(GMT+03:00) Riyadh',
		'Asia/Baghdad' => '(GMT+03:00) Baghdad',
		'Africa/Nairobi' => '(GMT+03:00) Nairobi',
		'Asia/Tbilisi' => '(GMT+03:00) Tbilisi',
		'Europe/Moscow' => '(GMT+03:00) Moscow',
		'Europe/Volgograd' => '(GMT+03:00) Volgograd',
		'Asia/Tehran' => '(GMT+03:30) Tehran',
		'Asia/Muscat' => '(GMT+04:00) Muscat',
		'Asia/Baku' => '(GMT+04:00) Baku',
		'Asia/Yerevan' => '(GMT+04:00) Yerevan',
		'Asia/Yekaterinburg' => '(GMT+05:00) Ekaterinburg',
		'Asia/Karachi' => '(GMT+05:00) Karachi',
		'Asia/Tashkent' => '(GMT+05:00) Tashkent',
		'Asia/Kolkata' => '(GMT+05:30) Calcutta',
		'Asia/Colombo' => '(GMT+05:30) Sri Jayawardenepura',
		'Asia/Katmandu' => '(GMT+05:45) Kathmandu',
		'Asia/Dhaka' => '(GMT+06:00) Dhaka',
		'Asia/Almaty' => '(GMT+06:00) Almaty',
		'Asia/Novosibirsk' => '(GMT+06:00) Novosibirsk',
		'Asia/Rangoon' => '(GMT+06:30) Yangon (Rangoon)',
		'Asia/Krasnoyarsk' => '(GMT+07:00) Krasnoyarsk',
		'Asia/Bangkok' => '(GMT+07:00) Bangkok',
		'Asia/Jakarta' => '(GMT+07:00) Jakarta',
		'Asia/Brunei' => '(GMT+08:00) Beijing',
		'Asia/Chongqing' => '(GMT+08:00) Chongqing',
		'Asia/Hong_Kong' => '(GMT+08:00) Hong Kong',
		'Asia/Urumqi' => '(GMT+08:00) Urumqi',
		'Asia/Irkutsk' => '(GMT+08:00) Irkutsk',
		'Asia/Ulaanbaatar' => '(GMT+08:00) Ulaan Bataar',
		'Asia/Kuala_Lumpur' => '(GMT+08:00) Kuala Lumpur',
		'Asia/Singapore' => '(GMT+08:00) Singapore',
		'Asia/Taipei' => '(GMT+08:00) Taipei',
		'Australia/Perth' => '(GMT+08:00) Perth',
		'Asia/Seoul' => '(GMT+09:00) Seoul',
		'Asia/Tokyo' => '(GMT+09:00) Tokyo',
		'Asia/Yakutsk' => '(GMT+09:00) Yakutsk',
		'Australia/Darwin' => '(GMT+09:30) Darwin',
		'Australia/Adelaide' => '(GMT+09:30) Adelaide',
		'Australia/Canberra' => '(GMT+10:00) Canberra',
		'Australia/Melbourne' => '(GMT+10:00) Melbourne',
		'Australia/Sydney' => '(GMT+10:00) Sydney',
		'Australia/Brisbane' => '(GMT+10:00) Brisbane',
		'Australia/Hobart' => '(GMT+10:00) Hobart',
		'Asia/Vladivostok' => '(GMT+10:00) Vladivostok',
		'Pacific/Guam' => '(GMT+10:00) Guam',
		'Pacific/Port_Moresby' => '(GMT+10:00) Port Moresby',
		'Asia/Magadan' => '(GMT+11:00) Magadan',
		'Pacific/Fiji' => '(GMT+12:00) Fiji',
		'Asia/Kamchatka' => '(GMT+12:00) Kamchatka',
		'Pacific/Auckland' => '(GMT+12:00) Auckland',
		'Pacific/Tongatapu' => '(GMT+13:00) Nukualofa');

        $feed_id = esc_attr($instance['feed_id']);
        $title = esc_attr($instance['title']);
        $max_results = esc_attr($instance['max_results']);
        $rs_offset = esc_attr($instance['rs_offset']);
        $timezone = esc_attr($instance['timezone']);
        $static_url_option = esc_attr($instance['static_url_option']);
        $static_url = esc_attr($instance['static_url']);
        $title_url_option = esc_attr($instance['title_url_option']);
        $title_url = esc_attr($instance['title_url']);
        $map_link = esc_attr($instance['map_link']);
        $pub_or_priv = esc_attr($instance['pub_or_priv']);
        $priv_id = esc_attr($instance['priv_id']);
        $show_date = esc_attr($instance['show_date']);

        ?>
        <div>
          <h4>Required</h4>
          <p><label for="<?php echo $this->get_field_id('feed_id'); ?>"><?php _e('Feed ID:'); ?> <input class="widefat" id="<?php echo $this->get_field_id('feed_id'); ?>" name="<?php echo $this->get_field_name('feed_id'); ?>" type="text" value="<?php echo $feed_id; ?>" /></label>
          </p>

          <h4>Optional</h4>
          <hr />
          <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Calendar Title:'); ?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label>
          </p>

          <p><label for="<?php echo $this->get_field_id('title_url_option'); ?>"><?php _e('Title URL:'); ?>
            <select name="<?php echo $this->get_field_name('title_url_option'); ?>" id="<?php echo $this->get_field_id('title_url_option'); ?>" >
                <option value="0" <?php echo ($title_url_option == 0) ? 'selected="selected"' : ''; ?>>None</option>
                <option value="1" <?php echo ($title_url_option == 1) ? 'selected="selected"' : ''; ?>>iCal</option>
                <option value="2" <?php echo ($title_url_option == 2) ? 'selected="selected"' : ''; ?>>HTML</option>
                <option value="3" <?php echo ($title_url_option == 3) ? 'selected="selected"' : ''; ?>>Specified</option>
            </select></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title_url'); ?>" name="<?php echo $this->get_field_name('title_url'); ?>" type="text" value="<?php echo $title_url; ?>" />
          </p>
          <p><label for="<?php echo $this->get_field_id('max_results'); ?>"><?php _e('Max Results:'); ?> <input class="widefat" id="<?php echo $this->get_field_id('max_results'); ?>" name="<?php echo $this->get_field_name('max_results'); ?>" type="text" value="<?php echo $max_results; ?>" /></label></p>

          <p><label for="<?php echo $this->get_field_id('rs_offset'); ?>"><?php _e('Results Offset:'); ?> <input class="widefat" id="<?php echo $this->get_field_id('rs_offset'); ?>" name="<?php echo $this->get_field_name('rs_offset'); ?>" type="text" value="<?php echo $rs_offset; ?>" /></label></p>

          <p><label for="<?php echo $this->get_field_id('show_date'); ?>"><?php _e('Date Header:'); ?>
            <select name="<?php echo $this->get_field_name('show_date'); ?>" id="<?php echo $this->get_field_id('show_date'); ?>" >
                <option value="none" <?php echo ($show_date == "none") ? 'selected="selected"' : ''; ?>>None</option>
                <option value="short" <?php echo ($show_date == "short") ? 'selected="selected"' : ''; ?>>Short (Jul 24)</option>
                <option value="long" <?php echo ($show_date == "long") ? 'selected="selected"' : ''; ?>>Long (July 24)</option>
            </select></label>
          </p>

          <p><label for="<?php echo $this->get_field_id('map_link'); ?>"><?php _e('Display link to map:'); ?>
            <select name="<?php echo $this->get_field_name('map_link'); ?>" id="<?php echo $this->get_field_id('map_link'); ?>" >
                <option value="0" <?php echo ($map_link == 0) ? 'selected="selected"' : ''; ?>>No</option>
                <option value="1" <?php echo ($map_link == 1) ? 'selected="selected"' : ''; ?>>Yes</option>
            </select></label>
          </p>

          <p><label for="<?php echo $this->get_field_id('static_url_option'); ?>"><?php _e('Single Event URL:'); ?>
            <select name="<?php echo $this->get_field_name('static_url_option'); ?>" id="<?php echo $this->get_field_id('static_url_option'); ?>" >
                <option value="0" <?php echo ($static_url_option == 0) ? 'selected="selected"' : ''; ?>>No</option>
                <option value="1" <?php echo ($static_url_option == 1) ? 'selected="selected"' : ''; ?>>Yes</option>
            </select></label>
            <input class="widefat" id="<?php echo $this->get_field_id('static_url'); ?>" name="<?php echo $this->get_field_name('static_url'); ?>" type="text" value="<?php echo $static_url; ?>" />
          </p>

          <p><label for="<?php echo $this->get_field_id('pub_or_priv'); ?>"><?php _e('Public or Private:'); ?>
            <select name="<?php echo $this->get_field_name('pub_or_priv'); ?>" id="<?php echo $this->get_field_id('pub_or_priv'); ?>" >
                <option value="0" <?php echo ($pub_or_priv == 0) ? 'selected="selected"' : ''; ?>>Public</option>
                <option value="1" <?php echo ($pub_or_priv == 1) ? 'selected="selected"' : ''; ?>>Private</option>
            </select></label>
            <input class="widefat" id="<?php echo $this->get_field_id('priv_id'); ?>" name="<?php echo $this->get_field_name('priv_id'); ?>" type="text" value="<?php echo $priv_id; ?>" />
          </p>

          <p><label for="<?php echo $this->get_field_id('timezone'); ?>"><?php _e('Timezone:'); ?>
            <select name="<?php echo $this->get_field_name('timezone'); ?>" id="<?php echo $this->get_field_id('timezone'); ?>" >
<?php
        foreach($zonelist as $key => $value) {
            if($timezone == $key)
	        echo '		<option value="' . $key . '" SELECTED>' . $value . '</option>' . "\n";
            else
	        echo '		<option value="' . $key . '">' . $value . '</option>' . "\n";
        }
?>
            </select></label>
          </p>
        </div>
        <?php 
    }

/**
 * @function get_title
 * @brief Generates the 'h2' header for the title of the calendar widget
 * @param $calGroup
 *   $calGroup is an array holding all relevant configuration from both the widget and the feed itself.
 * @param $feed_title_url_option
 *   $feed_title_url_option specifies what the title should link to,
 *   0 is no link, 1 is ical, 2 is HTML, and 3 is a specified link
 *
 * gcal_sidebar_display feed does most of the heavy lifting. It is
 * responsible for downloading the feed, parsing it, and 
 * generating the proper HTML. 
 *
 */
     function get_title($calGroup, $feed_title_url_option) {
             $feed_title = $calGroup['title'];
             $gcal_sidebar_id = $calGroup['feed_id'];
             switch($feed_title_url_option) {
             case 0:
                     $title = $feed_title;
                     break;
             case 1:
                     $feed_title_url = "http://www.google.com/calendar/ical/" . $gcal_sidebar_id . "/public/basic.ics";
                     $title = "<a href='" . $feed_title_url . "'>" . $feed_title . "</a>";
                     break;
             case 2:
                     $feed_title_url = "http://www.google.com/calendar/embed?src=" . $gcal_sidebar_id . "&ctz=" . $calGroup['timezone'];
                     $title = "<a href='" . $feed_title_url . "'>" . $feed_title . "</a>";
                     break;
             case 3:
                     $feed_title_url = get_option('gcal_sidebar_title_url');
                     $title = "<a href='" . $feed_title_url . "'>" . $feed_title . "</a>";
                     break;
             }
             return $title;
     } 

    function get_feed( $instance ) {
        $mapUrlBase        = "http://maps.google.com/maps";
        $feedUrlBase       = "http://www.google.com/calendar/feeds/";
        $feedUrlOpt        = "/full?orderby=starttime&sortorder=ascending&futureevents=true&singleevents=true&";
        $calGroup          = array('eventList' => array());
        $static_url_option = esc_attr($instance['static_url_option']);
        $static_url        = esc_attr($instance['static_url']);
        $wud               = wp_upload_dir();
        $dir               = $wud['basedir'] . "/gcal_sidebar";
        if(! is_dir($dir))
            mkdir($dir, 755, true);

        if(esc_attr($instance['rs_offset']))
            $rs_offset = esc_attr($instance['rs_offset']);
        else
            $rs_offset = 0;

        if(esc_attr($instance['max_results']))
            $max_results = $instance['max_results'] + $rs_offset;
        else
            $max_results = 4 + $rs_offset;

        $custom_fields = get_post_custom();
        if($custom_fields['gcal_sidebar_feed_id'][0] != '') {
            $feed_list = $custom_fields['gcal_sidebar_feed_id'][0];
        } else {
            $feed_list = $instance['feed_id'];
        }

        foreach(explode(",", $feed_list) as $feed_id) {
            if(esc_attr($instance['pub_or_priv']) && trim(esc_attr($instance['priv_id'])))
                $feedUrl = $feedUrlBase . $feed_id . "/private-" . trim(esc_attr($instance['priv_id'])) . $feedUrlOpt . "max-results=" . $max_results;
            else
                $feedUrl = $feedUrlBase . $feed_id . "/public" . $feedUrlOpt . "max-results=" . $max_results;
            try {
                $xmlstr = wp_remote_fopen($feedUrl);
                $staticUrl = $instance['static_url_option'];
                $xml = new SimpleXMLElement($xmlstr);

                // so far so good, let's cache it.
                $fname = $dir . "/" . $feed_id . ".xml";
                $fp = fopen($fname, 'w');
                fwrite($fp, $xmlstr);
                fclose($fp);
            } catch (Exception $e) {
                $fname = $dir . "/" . $feed_id . ".xml";
                if(!file_exists($fname)) {
                    $calGroup['title'] = "No Cached Calendar";
                    return $calGroup; 
                }
                else {
                    $xmlstr = file_get_contents($fname);
                    if($xmlstr == null) {
                        $calGroup['title'] = "Calendar Empty";
                        return $calGroup; 
                    }
                    else
                        $xml = new SimpleXMLElement($xmlstr);
                }
            }
            $gcal = $xml->children('http://schemas.google.com/gCal/2005');

            if(!isset($calGroup['feed_id'])) {
                if(esc_attr($instance['timezone']))
                    $calGroup['timezone'] = $instance['timezone'];
                else 
                    $calGroup['timezone'] = sprintf("%s", $gcal->timezone->attributes()->value);

                if(esc_attr($instance['title']))
                    $calGroup['title'] = $instance['title'];
                else 
                    $calGroup['title'] = $xml->title;
                $calGroup['feed_id'] = $feed_id;
            }

            foreach($xml->entry as $entry) {
                $gd = $entry->children('http://schemas.google.com/g/2005');
                if(isset($gd->where))
                    $where = sprintf("%s",$gd->where->attributes()->valueString);
                else
                    $where = "";

                if(isset($entry->content))
                    $description = sprintf("%s",$entry->content);
                else
                    $description = "";

                if($static_url_option)
                    $link = $static_url;
                else
                    $link = sprintf("%s&ctz=%s", $entry->link->attributes()->href, $calGroup['timezone']);

                if($entry->title == ''){
                    $title = "Busy";
                } else {
                    $title = sprintf("%s", $entry->title);
                }
                $event = array(
                               'title'       => $title,
                               'location'    => $where,
                               'description' => $description,
                               'startTime'   => strtotime($gd->when->attributes()->startTime),
                               'endTime'     => strtotime($gd->when->attributes()->endTime),
                               'link'        => $link
                              );
                $calGroup['eventList'][] = $event;
            }
        }

        for($iter; $iter < sizeof($calGroup['eventList']);$iter++) {
            usort($calGroup['eventList'], "cmp");
        }
        return($calGroup);
    }
/**
 * @function display_feed
 * @brief Downloads the Google Calendar and converts to HTML
 * @param $feed_id 
 *   $calGroup an array of events, populated by get_feed
 *   proper URLs for the HTML / ical / XML feeds.
 *
 * gcal_sidebar_display feed does most of the heavy lifting. It is
 * responsible for downloading the feed, parsing it, and 
 * generating the proper HTML. 
 *
 */
    function display_feed( $calGroup, $instance) {
        $map_url     = "http://maps.google.com/maps";
/*
 * input validation and default setup
 */
        if(!isset($instance['map_link']) || !is_numeric($instance['map_link']))
            $map_link = 0;
        else 
            $map_link = trim(esc_attr($instance['map_link']));

        if(!isset($instance['pub_or_priv']) || !is_numeric($instance['pub_or_priv']))
            $pub_or_priv = 0;
        else 
            $pub_or_priv = trim(esc_attr($instance['pub_or_priv']));

        if(!isset($instance['mode']) || (($instance['mode'] != "agenda") && ($instance['mode'] != "prose")))
            $mode = 'agenda';
        else 
            $mode = trim(esc_attr($instance['mode']));

        if(!isset($instance['show_date']) || (($instance['show_date'] != "short") && ($instance['show_date'] != "long")))
            $show_date = "none";
        else 
            $show_date = trim(esc_attr($instance['show_date']));

        if(!isset($instance['rs_offset']) || !is_numeric($instance['rs_offset']))
            $rs_offset = 0;
        else
            $rs_offset = trim(esc_attr($instance['rs_offset']));

        if(!isset($instance['max_results']) || !is_numeric($instance['max_results']))
            $max_results = 4 + $rs_offset;
        else 
            $max_results = trim(esc_attr($instance['max_results'])) + $rs_offset;

        if(!isset($instance['priv_id']) || !is_numeric($instance['priv_id']))
            $priv_id = 0;
        else 
            $priv_id = trim(esc_attr($instance['priv_id']));

        date_default_timezone_set ( $calGroup['timezone'] );

        if($show_date == "short" ) {
            $dFormat = "D, M j";
        }
        else if($show_date == "long" ) {
            $dFormat = "l, F j";
        }
        $lt = "ul";
        $li = "li";
        $before_title = '';
        $after_title = '';

        echo '<' . $lt . ' id="events">';

        $date = '';
        $olddate = '';
        $eventList = $calGroup['eventList'];
        for($iter = $rs_offset; $iter < $max_results && $iter < count($eventList); $iter++ ) {
            $event = $eventList[$iter];
            $date = date("Ymd", $event['startTime']);

            if($pub_or_priv == 0) {
                $href = "href='".$event['link']."'";
            }
            else {
                $href= '';
            }
            $link = sprintf("<a class='summary url' title='%s - %s' %s>%s%s%s</a>\n"
                            , esc_html($event['location'])
                            , esc_html($event['description'])
                            , $href
                            , $before_title
                            , esc_html($event['title'])
                            , $after_title
                           );
            if($mode == "agenda") {
              if((date("g:ia", $event['startTime'] - date("Z"))  == "12:00am") &&
                 (date("g:ia", $event['endTime']   - date("Z")) == "12:00am") &&
                 ($event['endTime'] - $event['startTime']) == (60 * 60 * 24)) {
                  $body = "All Day on " . date("l, F j", $event['startTime']);
              }
              else {
                  $body = sprintf("%s to %s", date("l, F j \\f\\r\o\m g:ia", $event['startTime']), date("g:ia", $event['endTime']));
              }
            }
            else if($mode == "prose") {
              $body = esc_html($event['description']);
            }

            if(($show_date != "none" ) && ($date != $olddate))
            	echo '  <li class="date"><h4>' . date($dFormat, $event['startTime']) . "</h4></li>";

            echo '  <' . $li . ' class="event vevent">';
            echo $link;
            if($map_link == 1) {
                $map_href = $map_url . "?view=map&iwloc=A&q=" . urlencode($event['location']);
                printf("<a class='map' title='Map near %s' href='%s'>map</a>", $event['location'], $map_href);
            }

            //$body = $event['description'];
            $isostart = date("c", $event['startTime']);
            printf("<p class='event_time dtstart value-title' title='%s'>%s</p></%s>", $isostart, $body, $li);
            $olddate = $date;
        }
        echo '  </' . $lt . '>';
    }
} // class GcalSidebar


add_action('widgets_init', create_function('', 'return register_widget("GcalSidebar");'));

?>
