<style>
    .accordion {
        height: auto;
        background: #fff;

    }

    .accordion > ul > li > a {
        display: block;
        color: #4d4d4d;
        padding: 10px 22px;
        background: #fff;
        border-bottom: 1px solid #f6f6f6;
        position: relative;
        cursor: pointer;
    }

    .accordion > ul > li > ul > li > a {
        padding: 9px 32px;
        display: block;
        background: #f5f5f5;
        color: #4d4d4d;
        cursor: pointer;
        border-bottom: 1px solid #f6f6f6;
    }

    .accordion > ul > li > ul > li > a:hover {
        background: #45a9ff;
        transition: all 300ms ease;
        color: #fff;
        border-bottom: 1px solid #45a9ff;
    }

    .accordion > ul li.has-sub > a::before {
        content: '';
        position: absolute;
        width: 10px;
        height: 2px;
        background: #4d4d4d;
        transition: all 300ms ease;
        left: 30px;
        top: 21px;
    }

    .accordion > ul li.has-sub > a::after {
        content: '';
        position: absolute;
        width: 2px;
        height: 10px;
        background: #4d4d4d;
        transition: all 300ms ease;
        left: 34px;
        top: 17px;
    }

    .accordion > ul li.has-sub.open > a::before, .accordion > ul li.has-sub.open > a::after {
        transition: all 300ms ease;
        transform: rotate(45deg);
    }

    .accordion ul ul {
        display: none;
    }
</style>
<div class="sidebar">
    <div class="accordion">
        <ul>
            <li><a href="./">داشبورد</a></li>
            <li class="has-sub active"><a href="#">مدیریت دسته بندی</a>
                <ul>
                    <li><a href="Categories.php">افزدون دسته بندی</a></li>
                </ul>
            </li>

            <li class="has-sub"><a href="">مدیریت مطالب</a>
                <ul>
                    <li><a href="addPost.php">افزدون مطلب</a></li>
                    <li><a href="Posts.php">مشاهده مطلب</a></li>
                </ul>
            </li>
            <li class="has-sub"><a href="">مدیریت نظرات</a>
                <ul>
                    <li><a href="Comments.php">مشاهده نظرات</a></li>
                </ul>
            </li>
            <li><a href="logout.php">خروج از پنل مدیریت</a></li>

        </ul>
    </div>
    <div class="clear"></div>
</div>
<script src="../js/jquery-3.3.1.min.js"></script>

<script>
    $(document).ready(function () {
        $('.accordion ul li.active').addClass('open').children('ul').show();
        $('.accordion ul li.has-sub > a').click(function () {
            $(this).removeAttr('href');
            var accordion = $(this).parent('li');
            if (accordion.hasClass('open')) {
                accordion.removeClass('open');
                accordion.find('ul').slideUp(500);
            } else {
                accordion.addClass('open');
                accordion.find('ul').slideDown(500);
                // accordion.siblings('li').children('ul').slideUp(500);
                // accordion.siblings('li').removeClass('open');
            }
        });
    });
</script>