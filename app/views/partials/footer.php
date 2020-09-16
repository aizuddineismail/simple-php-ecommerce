</div>

<!-- FOOTER -->
<footer class="bg-dark footer">
    <div class="container">
        <div class="row">
            <div class="col text-center">
                <h3 class="text-white font-weight-light p-3">BoostOrder Prework Assessment</h3>
                <p class="text-light py-4 m-0">&copy;Copyright 2020 - Made by Aizuddin</p>
            </div>
        </div>
    </div>
</footer>
<!-- FOOTER -->
<!-- JS, Popper.js, and jQuery -->
<!-- <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script> -->
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
    integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous">
</script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"
    integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous">

</script>
<!-- NOTIFICATIONS JQUERY -->
<script>
    var urlroot = '<?php echo URLROOT; ?>'
    var unreadNotification = 0;
    const audio = new Audio(`${urlroot}/public/audio/notifications.mp3`)
    var isLoggedIn = '<?php echo isLoggedIn(); ?>'

    $(document).ready(function() {
        if(isLoggedIn) {
            setInterval(getNewNotification, 1000);
            updateNotification();
        }

        function getNewNotification() {
            $.ajax({
                url: `${urlroot}/notifications/getNotification`,
                type: 'GET',
                dataType: 'json',
                success: function(obj) {
                    newNotificationNumber = 0
                    for(let i = 0; i < obj.length; i++) {
                        if (obj[i]['status'] == 'unread') {
                            newNotificationNumber += 1;
                        }
                    }

                    if (newNotificationNumber > unreadNotification) {
                        unreadNotification = newNotificationNumber
                        console.log(newNotificationNumber)
                        updateNotification();
                        $('#notification').addClass("fa-layers-counter");
                        audio.play();
                    } else if(unreadNotification == 0){
                        $('#notification').removeClass("fa-layers-counter")
                    }
                },
                // error: function(XMLHttpRequest, textStatus, errorThrown) {
                //     alert('Something went wrong');
                // }
            })
        }

        function updateNotification() {
            $("#dropdownList").empty()
            $("#dropdownList").append(`<a class="dropdown-item disabled">Notifications</a>`)
            $("#dropdownList").append(`<div class="dropdown-divider"></div>`)

            $.ajax({
                url: `${urlroot}/notifications/getAllNotifications`,
                type: 'GET',
                dataType: 'json',
                success: function(obj) {
                    for(let i = 0; i < obj.length; i++) {
                        $("#dropdownList").append(`<a class="notification-item dropdown-item" href="#">${obj[i]['message']}</a>`)
                    }
                }
            })
        }

        $("#notificationButton").click(function() {
            $.ajax({
                url: `${urlroot}/notifications/markAllAsRead`,
                type: 'PUT',
                success: function(obj) {
                    unreadNotification = 0;

                }
            })
        })
    })

</script>
</body>



</html>