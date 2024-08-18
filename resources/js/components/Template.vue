<template>
    <v-app>
        <v-app-bar :elevation="2" color="teal">
            <template v-slot:prepend>
                <v-app-bar-nav-icon @click.stop="navigation_bar = !navigation_bar"></v-app-bar-nav-icon>
            </template>
            <v-app-bar-title>Agenda Telefônica</v-app-bar-title>
        </v-app-bar>

        <v-navigation-drawer app
            v-model="navigation_bar"
            temporary
            color="teal"
        >
            <v-list
                height="100%"
                style="
                display: flex;
                flex-direction: column;
                justify-content: space-between;"
            >
                <v-list-item
                    prepend-icon="mdi-account"
                    slim
                    style="font-size: 14px;"
                >
                    <span class="truncate"> {{ user_name }} </span>
                </v-list-item>

                <v-list-item
                    link
                    prepend-icon="mdi-logout-variant"
                    title="Sair"
                    @click="Logout"
                ></v-list-item>

            </v-list>
        </v-navigation-drawer>

        <v-main>
            <slot></slot>
        </v-main>
    </v-app>
</template>
<script>
export default {
    data() {
        return {
            navigation_bar: false,
            user_name: '',
        }
    },
    methods: {
        Logout() {
            axios.get('/sair')
            .then(response => {
                window.location.replace(response.data.redirect);
            })
        },
        GetAuthUserName() {
            axios.get('/usuario/autenticado/obterNome')
            .then(response => {
                this.user_name = response.data.name;
            })
        }
    },
    mounted() {
        this.GetAuthUserName();
    }
}
</script>
<style>
.truncate {
  display: inline-block;
  width: 100%;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
  margin-top: 6px;
}

.v-data-table-header__content, .v-data-table__td-title {
    font-weight: bold;
    color: #646464;
}
</style>
