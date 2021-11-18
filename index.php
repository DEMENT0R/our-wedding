<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Наша свадьба | Наталья и Максим Безрукавниковы</title>
    <style>
        body{margin:0;}
        h1, h2, h3, h4 {
            font-family: calibri;
            text-align: center;
        }
        .cover{
            height: 100vh;
            background-image: url(/img/small/arp-251.jpg);
            background-size: cover;
            background-position: center;
            /*margin-top: -10px;*/
        }
        .title{
            position: relative;
            top: 60%;
            padding: 10px;
            background-color: rgba(0, 0, 0, 0.5);
            color: white;
        }
        @media (max-width: 768px) {
            .cover{
                background-image: url(/img/small/arp-170.jpg);
            }
        }
        .pimg {
            min-width: 200px;
            min-height: 200px;
        }
    </style>
    <link rel="stylesheet" href="/css/glightbox.min.css">
    <script src="/js/glightbox.min.js"></script>
</head>
<body>

    <div class="cover">
        <div class="title">
            <h1>Максим и Наталья</h1>
            <hr width="20%">
            <h3>Фотограф Алексей Рудич</h3>
            <h4>2019.06.15</h4>
        </div>
    </div>

    <div class="grid">
        <?php
            $full_images_dir = "img/full";
            $directory = "img/small";    // Папка с изображениями
            $allowed_types=array("jpg", "png", "gif");  //разрешеные типы изображений
            $file_parts = array();
              $ext="";
              $title="";
              $i=0;
            //пробуем открыть папку
              $dir_handle = @opendir($directory) or die("Ошибка при открытии папки ".$directory." !!!");
            while ($file = readdir($dir_handle))    //поиск по файлам
              {
              if($file=="." || $file == "..") continue;  //пропустить ссылки на другие папки
              $file_parts = explode(".",$file);          //разделить имя файла и поместить его в массив
              $ext = strtolower(array_pop($file_parts));   //последний элеменет - это расширение


              if(in_array($ext,$allowed_types))
              {
              echo '<a href="'.$full_images_dir.'/'.$file.'" class="glightbox"><img data-src="'.$directory.'/'.$file.'" class="pimg lazy" title="'.$file.'" alt="image" /></a>';
             $i++;
              }

              }
            closedir($dir_handle);  //закрыть папку
            ?>
    </div>

    <script type="text/javascript" src="/js/jquery-1.11.1.min.js"></script>
    <script type="text/javascript" src="/js/gridify.js"></script>
    <script type="text/javascript">
        $(window).load(function() {
            var options =
            {
                srcNode: 'img',             // grid items (class, node)
                margin: '10px',             // margin in pixel, default: 0px
                width: '400px',             // grid item width in pixel, default: 220px
                max_width: '',              // dynamic gird item width if specified, (pixel)
                resizable: true,            // re-layout if window resize
                transition: 'all 0.5s ease' // support transition for CSS3, default: all 0.5s ease
            }
            $('.grid').gridify(options);
        });
    </script>

    <script type="text/javascript">
        const lightbox = GLightbox({
            touchNavigation: true,
            loop: true,
            autoplayVideos: true,
            onOpen: () => {
                console.log('Lightbox opened')
            },
            beforeSlideLoad: (slide, data) => {
                // Need to execute a script in the slide?
                // You can do that here...
            }
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
          var lazyloadImages;    

          if ("IntersectionObserver" in window) {
            lazyloadImages = document.querySelectorAll(".lazy");
            var imageObserver = new IntersectionObserver(function(entries, observer) {
              entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                  var image = entry.target;
                  image.src = image.dataset.src;
                  image.classList.remove("lazy");
                  imageObserver.unobserve(image);
                }
              });
            });

            lazyloadImages.forEach(function(image) {
              imageObserver.observe(image);
            });
          } else {  
            var lazyloadThrottleTimeout;
            lazyloadImages = document.querySelectorAll(".lazy");

            function lazyload () {
              if(lazyloadThrottleTimeout) {
                clearTimeout(lazyloadThrottleTimeout);
              }    

              lazyloadThrottleTimeout = setTimeout(function() {
                var scrollTop = window.pageYOffset;
                lazyloadImages.forEach(function(img) {
                    if(img.offsetTop < (window.innerHeight + scrollTop)) {
                      img.src = img.dataset.src;
                      img.classList.remove('lazy');
                    }
                });
                if(lazyloadImages.length == 0) { 
                  document.removeEventListener("scroll", lazyload);
                  window.removeEventListener("resize", lazyload);
                  window.removeEventListener("orientationChange", lazyload);
                }
              }, 20);
            }

            document.addEventListener("scroll", lazyload);
            window.addEventListener("resize", lazyload);
            window.addEventListener("orientationChange", lazyload);
          }
        })
        </script>
</body>
</html>
