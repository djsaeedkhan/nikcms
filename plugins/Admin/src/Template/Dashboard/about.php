
<div class="about-section">
    <h3 class="about-titles"><?=  __d('Admin', 'درباره سامانه')?></h3>
    <div class="row">
        <div class="col-sm-6 about-right">
            <h4 class="m-1">
                سامانه مدیریت محتوا ماهان 
                <span class="badge badge-dark">
                    نسخه 1.2
                </span>
            </h4>
            <p class="text-justify mt-3 p-1 pl-4">
                سیستم مدیریت محتوا ، ترجمه عبارت CMS
                است ، که به معنای سیستم نرم افزاری ای است که به کمک آن محتوا مدیریت می شود و به نرم افزارهایی گفته می شود که نظام قابل مدیریتی را در ثبت , بروزرسانی و
                بازیابی محتوا فراهم می آورند . این نرم افزارها الزاما وابسته به وب نیستند و برنامه های کاربردی
                مدیریت محتوای وب سایت های اینترنتی , صصرفا یک نمونه از این گونه سیستم های مدیریت 
                محتوا می باشد. لکن در کشور ما ایران ، بعلت گسترش این شاخه از نرم افزارهای سیستم مدیریت 
                محتوا 
                , عبارت cms تتنها به نرم افزارهای مدیریت وب سایت اطلاق می شود. 
            </p>
        </div>
        <div class="col-sm-6 about-left">
            <?php echo $this->html->image('/admin/img/cms.jpg',['class'=>'img-thumbnail']);?>
        </div>
    </div>
</div>
<div class="clearfix"></div><br><bR>


<style>

h3.about-titles {
    font-size: 3.5em;
    text-align: center;
    margin-bottom: 1.3em;
    position: relative;
    
}
h3.about-titles:before, h3.about-titles:after {
    content: " ";
    background: #490382;
    position: absolute;
    width: 18%;
    height: 1px;
}
h3.about-titles:after {
    right: 41%;
    top: 102%;
}
.about-right h3 {
    font-size: 3em;
    letter-spacing: 1px;
    color: #490382;
}
.about-right p {
    font-size: 1.2em;
    border-left: 7px solid #000;
    padding: 1em 1em 1em 2em;
    margin: 2em 0 0;
}
.about-left img {
    width: 100%;
}
.benefit-right img {
    width: 100%;
}
.icon {
    color : white;
    padding:15px;
    font-size:30px;
}
.benefit-section {
    background-color:#4f003d;
    background-size: cover;
    -webkit-background-size: cover;
    -moz-background-size: cover;
    -o-background-size: cover;
    -ms-background-size: cover;
}

.benefit-section {
    padding: 5em 0;
}

h3.site-titles {
    font-size: 3.5em;
    text-align: center;
    margin-bottom: 1.3em;
    position: relative;
    color: #fff;
}
h3.site-titles:before, h3.site-titles:after {
    content: " ";
    background: #ededed;
    position: absolute;
    width: 16%;
    height: 1px;
}

h3.site-titles:after {
    right: 42%;
    top: 102%;
}

p {
    display: block;
    -webkit-margin-before: 1em;
    -webkit-margin-after: 1em;
    -webkit-margin-start: 0px;
    -webkit-margin-end: 0px;
}
.pixi_two_grid_right_gridr h4 {
    font-size: 1.5em;
    color: #ededed;
}
.pixi_two_grid_right_gridr p {
    color: #dedede;
    line-height: 2em;
}
.pixi_two_grid_right_grid1 {
    width: 65px;
    height: 65px;
    text-align: center;
    border: 1px solid #fff;
}
p.site_para {
    font-size: 2em;
    color: #fff;
    text-align: center;
    letter-spacing: 4px;
}

.box > .icon { text-align: center; position: relative; }
.box > .icon > .image { position: relative; z-index: 2; margin: auto; width: 88px; height: 88px; border: 8px solid white; line-height: 88px; border-radius: 50%; background: #00bfff; vertical-align: middle; }
.box > .icon:hover > .image { background: #333; }
.box > .icon > .image > i { font-size: 36px !important; color: #fff !important; }
.box > .icon:hover > .image > i { color: white !important; }
.box > .icon > .info { margin-top: -24px; background: rgba(0, 0, 0, 0.04); border: 1px solid #e0e0e0; padding: 15px 0 10px 0; min-height:163px;}
.box > .icon:hover > .info { background: rgba(0, 0, 0, 0.04); border-color: #e0e0e0; color: white; }
.box > .icon > .info > h3.title { font-family: "Robot",sans-serif !important; font-size: 16px; color: #222; font-weight: 700; }
.box > .icon > .info > p { font-family: "Robot",sans-serif !important; font-size: 13px; color: #666; line-height: 1.5em; margin: 20px;}
.box > .icon:hover > .info > h3.title, .box > .icon:hover > .info > p, .box > .icon:hover > .info > .more > a { color: #222; }
.box > .icon > .info > .more a { font-family: "Robot",sans-serif !important; font-size: 12px; color: #222; line-height: 12px; text-transform: uppercase; text-decoration: none; }
.box > .icon:hover > .info > .more > a { color: #fff; padding: 6px 8px; background-color: #63B76C; }
.box .space { height: 30px; }

@media only screen and (max-width: 768px)
{
    .contact-form
    {
        margin-top:25px; 
    }

    .btn-send
    {
        width: 100%;
        padding:10px; 
    }

    .second-portion
    {
        margin-top:25px; 
    }
}
</style>    