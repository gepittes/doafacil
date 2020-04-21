<template>
  <v-data-table
    :headers="headers"
    :items="desserts"
    :search="search"
    sort-by="quantidade"
    sort-desc
  >
    <template v-slot:top>
      <v-toolbar flat color="white">
        <!-- Modal Confirm -->
        <v-dialog v-model="modal" persistent max-width="320">
          <v-card>
            <v-card-title class="headline text-center">Tem certeza que deseja deletar este item?</v-card-title>
            <v-card-actions>
              <div class="flex-grow-1"></div>
              <v-btn color="green darken-1" text @click="modal = false">Cancelar</v-btn>
              <v-btn color="red darken-1" text @click="confirmModal()">Sim, quero deletar!</v-btn>
            </v-card-actions>
          </v-card>
        </v-dialog>
        <!-- Modal Confirm -->
        <!-- Modal Create and Edit -->
        <v-dialog v-model="dialog" max-width="500px">
          <template v-slot:activator="{ on }">
            <v-btn color="primary" dark class="mb-2" v-on="on" v-if="isPageManager">Novo Item</v-btn>
            <v-spacer></v-spacer>
            <v-text-field
              v-model="search"
              class="mr-5"
              label="Busque itens por aqui"
              single-line
              hide-details
            ></v-text-field>
          </template>

          <v-card>
            <v-form ref="form" v-model="valid">
              <v-card-title>
                <span class="headline">{{formTitle}}</span>
              </v-card-title>

              <v-card-text>
                <v-container>
                  <v-row>
                    <p class="ml-5 mb-0 grey--text">
                      Em
                      <b>Unidade de medida</b> especifique o tipo de unidade que remeta a quantidade.
                      <b>Ex: 10 metros de Madeiras</b>
                    </p>
                    <v-col cols="12" sm="6" md="12">
                      <v-text-field
                        v-model="editedItem.nome"
                        label="Nome do Item"
                        :rules="[rules.required]"
                      ></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6" md="6">
                      <v-text-field
                        v-model="editedItem.quantidade"
                        label="Quantidade"
                        :rules="[rules.required]"
                        type="number"
                      ></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6" md="6">
                      <v-select
                        :items="items"
                        v-model="editedItem.unidade"
                        :rules="[rules.required]"
                        label="Unidade de Medida"
                      ></v-select>
                    </v-col>
                  </v-row>
                </v-container>
              </v-card-text>

              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="blue darken-1" text @click="close">Cancelar</v-btn>
                <v-btn color="blue darken-1" text @click="save">Salvar</v-btn>
              </v-card-actions>
            </v-form>
          </v-card>
        </v-dialog>
        <!-- Modal Create and Edit -->
      </v-toolbar>
    </template>
    <template v-slot:item.actions="{ item }">
      <v-icon small class="mr-2" @click="editItem(item)">fa fa-edit</v-icon>
      <v-icon small @click="deleteItem(item)">fa fa-trash</v-icon>
    </template>
  </v-data-table>
</template>

<script>
import { mapActions } from 'vuex'

export default {
  name: 'DataTableItens',
  props: ['instituicao', 'itens'],
  data: () => ({
    dialog: false,
    modal: false,
    itemModal: '',
    search: '',
    valid: true,
    rules: { required: (value) => !!value || 'Campo Obrigatório.' },
    items: ['Kilos/Kg', 'Litros/L', 'Metros/M'],
    isPageManager: false,
    heads: [
      {
        text: 'Nome do Item',
        align: 'start',
        sortable: false,
        value: 'nome',
      },
      { text: 'Quantidade', value: 'quantidade', sortable: true },
      { text: 'Unidade de Medida', value: 'unidade' },
    ],
    desserts: [],
    editedIndex: -1,
    editedItem: {
      nome: '',
      quantidade: 0,
    },
    defaultItem: {
      nome: '',
      quantidade: 0,
    },
  }),

  computed: {
    formTitle () {
      return this.editedIndex === -1 ? 'Novo Item' : 'Editar Item'
    },

    headers () {
      if (this.isPageManager) {
        return [...this.heads, { text: 'Ações', value: 'actions', sortable: false }]
      }

      return this.heads
    }
  },

  watch: {
    dialog (val) {
      val || this.close()
    },
    itens () {
      this.desserts = [...this.itens.itens]
    }
  },

  created () {
    if (this.$route.path === '/itens') this.isPageManager = true
  },

  methods: {
    ...mapActions({
      storeItem: 'item/storeItem',
      removeItem: 'item/deleteItem',
      updateItem: 'item/updateItem'
    }),

    editItem (item) {
      this.editedIndex = this.desserts.indexOf(item)
      this.editedItem = Object.assign({}, item)
      this.dialog = true
    },

    deleteItem (item) {
      this.modal = true
      this.itemModal = item
    },

    confirmModal () {
      this.removeItem(this.itemModal)
      this.modal = false
    },

    close () {
      this.dialog = false
      this.$refs.form.resetValidation()
      setTimeout(() => {
        this.editedItem = Object.assign({}, this.defaultItem)
        this.editedIndex = -1
      }, 300)
    },

    save () {
      if (this.$refs.form.validate()) {
        if (this.editedIndex > -1) {
          this.updateItem(this.editedItem);
        } else {
          let item = {
            nome: String(this.editedItem.nome),
            quantidade: Number(this.editedItem.quantidade),
            unidade: String(this.editedItem.unidade),
            instituicao_id: Number(this.instituicao.id),
          }
          this.storeItem(item);
        }
        this.close()
      }
    },
  },
}
</script>