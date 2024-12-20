<?php include_once(__DIR__ . '/../../../public/s-assets/head.html') ?>

<style>
    body,
    html {
        height: 100%;
        margin: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        font-family: 'Tahoma', 'Verdana', sans-serif;
        background-color: #f5f5f5;
    }

    .card {
        background-color: #f2f2f2;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0px 0px 10px rgba(10, 5, 5, 0.1);
        text-align: center;
        width: 350px;
    }

    .error {
        color: red;
        font-size: 0.9em;
        margin-bottom: 10px;
    }

    .btn {
        padding: 10px 15px;
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .btn:hover {
        background-color: #0056b3;
    }

    input[type="email"],
    input[type="password"] {
        width: 100%;
        padding: 10px;
        margin: 10px 0;
        border: 1px solid #ddd;
        border-radius: 5px;
    }
</style>
</head>

<body>
    <div class="card">
        <h2>Account register</h2>
        <p class="text-dark">Wellcome! create new account to be able to log in.</p>



        <form action="/register" method="post">
            <!-- Token CSRF -->
            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">

            <input type="email" name="email" placeholder="Email ou usuário" required>
            <input type="password" name="password" placeholder="Senha" required>
            <?php if (isset($_SESSION['error'])): ?>
                <div class="error"><?= $_SESSION['error'];
                                    unset($_SESSION['error']); ?></div>
            <?php endif; ?>
            <button type="submit" class="btn">create account</button>

        </form>

        <p><a href="/login">let's login</a></p>
    </div>
</body>

</html>