<template>

    <nav class="navbar navbar-expand-lg bg-white mb-3 border rounded">

        <div class="container">

            <a class="navbar-brand" href="#">

                <img :src="menuIcon" width="30px" alt="">

            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">

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

                        <RouterLink to="/situations" class="nav-link" active-class="nav-link active">

                            Situações

                        </RouterLink>

                    </li>

                    <li class="nav-item">

                        <RouterLink to="/categories" class="nav-link" active-class="nav-link active">

                            Categorias

                        </RouterLink>

                    </li>

                    <li class="nav-item">

                        <RouterLink to="/groups" class="nav-link" active-class="nav-link active">

                            Grupos

                        </RouterLink>

                    </li>

                    <li class="nav-item">

                        <RouterLink to="/types" class="nav-link" active-class="nav-link active">

                            Tipos

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

<script setup>

import menuIcon from '@/assets/images/note.png';

</script>