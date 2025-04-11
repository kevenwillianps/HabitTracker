<template>

    <nav class="navbar navbar-expand-lg bg-body-tertiary shadow-sm border-bottom">

        <div class="container">

            <a class="navbar-brand" href="#">Navbar</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">

                <span class="navbar-toggler-icon"></span>

            </button>

            <div class="collapse navbar-collapse" id="navbarNav">

                <ul class="navbar-nav">

                    <li class="nav-item">

                        <RouterLink to="/" class="nav-link" active-class="nav-link active">

                            Usuários

                        </RouterLink>

                    </li>

                    <li class="nav-item">

                        <RouterLink to="/habits" class="nav-link" active-class="nav-link active">

                            Hábitos

                        </RouterLink>

                    </li>

                </ul>

            </div>

        </div>

    </nav>

</template>

<script>

export default{
    
}

</script>