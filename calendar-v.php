<script src="https://unpkg.com/@popperjs/core@2"></script>

<style type="text/css">
    hr {
        height: 1px;
        overflow: hidden;
        font-size: 0;
        line-height: 0;
        background: #ccc;
        margin: 50px 0;
        border: 0;
    }

    /* css for calendar */
    .today,
    .holiday,
    .workitoff {
        color: #fff;
        border-radius: 50%;
    }
    .holiday,
    .workitoff {
        cursor: pointer;
    }
    .today {
        background-image: linear-gradient(302deg, #e7e51a, #0baa53 95%);
    }
    .holiday {
        background-image: linear-gradient(131deg, #ec358f 46%, #ed7225 106%);
    }
    .workitoff {
        background-image: linear-gradient(131deg, #20A6DF 40%, #e7e51a 115%);
    }
    .b-calendar {
        font: 14px/1.2 Arial, sans-serif;
        background: #fff;
    }
    .b-calendar--along {
        width: 300px;
        padding: 30px 40px;
        margin: 50px auto;
    }
    .b-calendar--many {
        padding: 20px;
        display: inline-block;
        vertical-align: top;
        margin: 0 20px 20px;
    }
    .b-calendar__title {
        text-align: center;
        margin: 0 0 20px;
    }
    .b-calendar__year {
        font-weight: bold;
        color: #333;
    }
    .b-calendar__tb {
        width: 100%;
    }
    .b-calendar__head {
        font: bold 14px/1.2 Arial, sans-serif;
        padding: 5px;
        text-align: left;
        border-bottom: 1px solid #c0c0c0;
    }
    .b-calendar__np {
        padding: 5px;
    }
    .b-calendar__day {
        font: 14px/1.2 Arial, sans-serif;
        padding: 8px 5px;
        text-align: left;
    }
    .b-calendar__number {
        display: inline-block;
        width: 30px;
        height: 30px;
        font-size: 15px;
        line-height: 29px;
        text-align: center;
        vertical-align: middle;
    }
    .b-calendar__weekend {
        color: red;
    }
    .b-calendar__month {
        font-size: 24px;
    }
    td:hover {
        background-color: rgba(32, 166, 223, 0.16);
        color: #20a6df;
    }
    td div {
        margin:0 auto;
    }
</style>

<div class="container">
    <div class="row calendar-table">
        <?=$calendar?>
    </div>
</div>


<script>
    $('.holiday, .workitoff').popover({
        html : true,
        trigger: 'hover',
        placement: 'top'
    });
</script>
