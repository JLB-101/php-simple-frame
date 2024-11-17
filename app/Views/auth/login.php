<!-- style -->
<style>
    body,
    html {
        height: 100%;
        margin: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        font-family: 'Tahoma', 'Verdana', 'Trebuchet MS', sans-serif;
        color: #181A1C;
        z-index: 100%;
    }

    .label-field {
        color: rgb(11, 11, 11);
        font-weight: 300;
        text-decoration: none;
        display: flex;
        flex-direction: column;
    }

    .input-field {
        display: flex;
        flex-direction: column;
        text-align: center;


    }

    .card {
        background-color: #fff;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0px 0px 10px rgba(12, 180, 222, 0.1);
        text-align: center;
    }
</style>
<!-- head-->
<?php include_once(__DIR__ . '/../../../public/s-assets/head.html') ?>

<!-- BODY -->
<main class="container-md">
    <div class="form">
        <div class="card py-sm">
            <h2 class="text-center">Login</h2>
            <p class="text-center text-dark"> Wellcome! > put your credetial to start. .. </p>
            <form>
                <div class="mb-3">
                    <input type="email" name="email" placeholder="Email or username" required>
                </div>
                <div class="mb-3">
                    <input type="password" name="password" placeholder="Password" required>
                </div>

                <div class="mb-3">
                 <input type="submit" value="start" class="btn btn-primary text-light"> | <a href="/" class="">go back</a>

                </div>
                <hr>
                <a href="#" class="btn btn-secondary btn-sm">sign-up</a>
            </form>
        </div>
</main>

<!-- Footer -->
<?php include_once(__DIR__ . '/../../../public/s-assets/footer.html') ?>
<!-- Scripts -->
<!-- end Scripts -->
</body>
<!-- end BOBY -->

</html>