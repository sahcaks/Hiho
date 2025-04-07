<!DOCTYPE html>
<html>

<head>
    <title>Слайдер отзывов</title>
    <?php
    include "shared_styles.php";
    ?>
    <style>
        .slider {
            width: 90%;
            margin-top: 3%;
            padding-right: 5%;
            margin-right: 5%;
            margin-left: 5%;
            overflow: hidden;
            position: relative;
            box-sizing: border-box;
        }

        .slides-container {
            width: 100%;
            display: flex;
            transition: transform 0.5s ease-in-out;
        }

        element.style {
            width: 0;
        }

        .slide {
            width: 33%;
            flex-shrink: 0;
            background-color: #f8f5f0;
            border: none;
            border-radius: 5px;
            margin-right: 3%;

        }

        .slide-content h3 {
            color: #28241f;
            ;
        }

        .controls {
            margin-top: 3%;
            margin-left: 3%;
            text-align: center;
        }

        .controls button {
            margin: 0 1%;
        }

        .prev-btn {
            font-family: Poiret one;
            color: #28241f;
            font-weight: 100;
            font-size: 52px;
            background-color: #f8f5f0;
            border: none;
        }

        .next-btn {
            font-family: Poiret one;
            color: #28241f;
            font-weight: 100;
            font-size: 52px;
            background-color: #f8f5f0;
            border: none;
        }
    </style>
</head>

<body>
    <div class="slider">
        <div class="slides-container">
            <?php
            include 'database.php';

            // Получаем отзывы из базы данных
            $query = "SELECT * FROM reviews ORDER BY created_at DESC";
            $result = mysqli_query($link, $query);

            if (mysqli_num_rows($result) > 0) {
                $reviews = mysqli_fetch_all($result, MYSQLI_ASSOC);
                $reviewsCount = count($reviews);
                $reviewsToShow = 1;
                $startIndex = 0;

                while ($startIndex < $reviewsCount) {
                    $endIndex = $startIndex + $reviewsToShow;
                    $currentReviews = array_slice($reviews, $startIndex, $reviewsToShow);
                    ?>

                    <div class="slide">
                        <?php foreach ($currentReviews as $review) {
                            $content = $review['content'];
                            $rating = $review['rating'];
                            $username = $review['username'];
                            $createdAt = $review['created_at'];
                            ?>

                            <div class="slide-content">
                                <h3><?php echo $username; ?></h3>
                                <p><?php echo $content; ?></p>
                                <p>Оценка: <?php echo $rating; ?></p>
                                <p>Дата и время: <?php echo $createdAt; ?></p>
                            </div>

                        <?php } ?>
                    </div>

                    <?php
                    $startIndex = $endIndex;
                }
            } else {
                echo 'Нет доступных отзывов.';
            }
            ?>
        </div>

        <div class="controls">
            <button class="prev-btn">
                < </button>
                    <button class="next-btn">></button>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            var slider = $('.slider');
            var slidesContainer = slider.find('.slides-container');
            var slides = slidesContainer.find('.slide');
            var slideCount = slides.length;
            var currentIndex = 0;
            var slidesToShow = 3;
            var slideWidth = slider.width() / slidesToShow;

            slides.css('width', slideWidth);

            function showSlides() {
                var transformValue = -(slideWidth * currentIndex);
                slidesContainer.css('transform', 'translateX(' + transformValue + 'px)');
            }

            function nextSlide() {
                currentIndex++;
                if (currentIndex >= slideCount) {
                    currentIndex = 0;
                }
                showSlides();
            }

            function prevSlide() {
                currentIndex--;
                if (currentIndex < 0) {
                    currentIndex = slideCount - 1;
                }
                showSlides();
            }

            $('.next-btn').click(function () {
                nextSlide();
            });

            $('.prev-btn').click(function () {
                prevSlide();
            });

            showSlides();
        });
    </script>
</body>

</html>