<?php


class Calendar extends MY_controller
{
    public $id = 57; // id ��������

    public function __construct() {
        parent::__construct();

        $this->load->helper('url');
    }

    public function index() {
        $calendar = '';
        $year = date('Y');
        //$months = $this->lang->line('oes_months_arr');
        $months = Array(
            0 => 'ѳ����',
            1 => '�����',
            2 => '��������',
            3 => '������',
            4 => '�������',
            5 => '�������',
            6 => '������',
            7 => '�������',
            8 => '��������',
            9 => '�������',
            10 => '��������',
            11 => '�������'
        );

        for ($month = 1; $month <= 12; $month++) {

            $calendar .= '<div class="b-calendar b-calendar--many">';
            $calendar .= '<div class="b-calendar__title"><h2 class="b-calendar__month">'.$months[$month-1].'</h2></div>';
            $calendar .= $this->draw_calendar($month, $year);
            $calendar .= '</div>';

        }

        $local_config = $this->init_cat_item($this->id);

        $content = $this->load->view('calendar', [
            'calendar'  => $calendar
        ], true);

        $config = [
            'other_menu'	=> true,
            'content'		=> $content
        ];

        $this->load->view("nd_layout", array_merge($config, $local_config));
    }

    /**
     * https://davidwalsh.name/php-calendar
     *
     * @param $month
     * @param $year
     * @param string $action
     * @return string
     */
    public function draw_calendar($month, $year, $action = 'none') {

        $holidays = array(
            '2020-01-01' => '����� г�',
            '2020-01-06' => '�������� �� ����� г����',
            '2020-01-07' => 'г����',
            '2020-03-08' => '8 �������',
            '2020-03-09' => '�������� �� ����� 8 �������',
            '2020-04-19' => '�����',
            '2020-04-20' => '�������� �� ����� �����',
            '2020-05-01' => '���� �����',
            '2020-05-09' => '���� ��������',
            '2020-05-11' => '�������� �� ����� ��� ��������',
            '2020-06-07' => '�����',
            '2020-06-08' => '�������� �� ����� �����',
            '2020-06-28' => '���� ����������� ������',
            '2020-06-29' => '�������� �� ����� ��� ����������� ������',
            '2020-08-24' => '���� ����������� ������',
            '2020-10-14' => '���� ��������� ������',
            '2020-12-25' => '���������� �����',
        );

        $work_it_off = array(
            '2020-01-11' => '³����������� �� 6 ����',
        );

        $calendar = '<table cellpadding="0" cellspacing="0" class="b-calendar__tb">';

        // ����� ���� ������
        $headings = array('��','��','��','��','��','��','��');
        $calendar.= '<tr class="b-calendar__row">';
        for($head_day = 0; $head_day <= 6; $head_day++) {
            $calendar.= '<th class="b-calendar__head';
            // �������� �������� ���
            if ($head_day != 0) {
                if (($head_day % 5 == 0) || ($head_day % 6 == 0)) {
                    $calendar .= ' b-calendar__weekend';
                }
            }

            $calendar .= '">';
            $calendar.= '<div class="b-calendar__number">'.$headings[$head_day].'</div>';
            $calendar.= '</th>';
        }
        $calendar.= '</tr>';

        // ���������� ������ ������ �� �����������
        $running_day = date('w',mktime(0,0,0,$month,1,$year)); // ���� ������, � �������� ���������� �����
        $running_day = $running_day - 1;
        if ($running_day == -1) {
            $running_day = 6;
        }

        $days_in_month = date('t',mktime(0,0,0,$month,1,$year)); // ���-�� ���� � ������
        $day_counter = 0;
        $days_in_this_week = 1;
        $dates_array = array();

        // ������ ������ ���������
        $calendar.= '<tr class="b-calendar__row">';

        // ����� ������ �����
        for ($x = 0; $x < $running_day; $x++) {
            $calendar.= '<td class="b-calendar__np"></td>';
            $days_in_this_week++;
        }


        // ����� �� �����, ����� �� ������ � ������ ������
        for($list_day = 1; $list_day <= $days_in_month; $list_day++) {
            $calendar.= '<td class="b-calendar__day';

            // �������� �������� ���
            if ($running_day != 0) {
                if (($running_day % 5 == 0) || ($running_day % 6 == 0)) {
                    $calendar .= ' b-calendar__weekend';
                }
            }
            $calendar .= '">';

            $current_day = date('d');
            $current_month = date('m');

           $search_date = date('Y-m-d', mktime(0,0,0,$month, $list_day, $year));

            // �������� �� ����������� ���� � ������� �����
            if ( $list_day == $current_day && $month == $current_month ) {
                $calendar.= '<div class="b-calendar__number today">'.$list_day.'</div>';
            }
            elseif ( array_key_exists($search_date, $holidays) ) {
                // ��������
                $calendar.= '<div class="b-calendar__number holiday" data-toggle="popover" data-content="<span>'. $holidays[$search_date] .'</span>">'.$list_day.'</div>';
            }
            elseif ( array_key_exists($search_date, $work_it_off) ) {
                // ���������
                $calendar.= '<div class="b-calendar__number workitoff" data-toggle="popover" data-content="<span>'. $work_it_off[$search_date] .'</span>">'.$list_day.'</div>';
            }
            else {
                // ������� ���� - �� ������� � �� �����������.
                $calendar.= '<div class="b-calendar__number">'.$list_day.'</div>';
            }

            $calendar.= '</td>';

            // ����� �� ���������� ��� ������
            if ($running_day == 6) {
                // ��������� ������
                $calendar.= '</tr>';
                // ���� ���� �� ��������� � ������, �������� ��������� ������
                if (($day_counter + 1) != $days_in_month) {
                    $calendar.= '<tr class="b-calendar__row">';
                }
                // ���������� ��������
                $running_day = -1;
                $days_in_this_week = 0;
            }

            $days_in_this_week++;
            $running_day++;
            $day_counter++;
        }

        // ������� ������ ������ � ����� ��������� ������
        if ($days_in_this_week < 8) {
            for($x = 1; $x <= (8 - $days_in_this_week); $x++) {
                $calendar.= '<td class="b-calendar__np"> </td>';
            }
        }
        $calendar.= '</tr>';
        $calendar.= '</table>';

        return $calendar;
    }

}