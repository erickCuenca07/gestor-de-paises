<template>
<v-container>
  <v-toolbar color="red">
      <v-toolbar-title>Prueba Auren</v-toolbar-title>
  </v-toolbar>
</v-container>
<v-container>
  <v-card class="mx-auto">
    <v-card-item>
      <v-card-title>Gestor de Paises</v-card-title>
      <v-card-subtitle>Para añadir un nuevo pais, se añadira por el nombre del mismo</v-card-subtitle>
    </v-card-item>
    <v-card-text>
      <v-form @submit.prevent="addCountry">
        <v-row>
          <v-col cols="12" md="4">
            <v-text-field v-model.trim="country" label="Nombre del pais" required></v-text-field>
          </v-col>
          <v-col cols="12" md="4">
            <v-btn density="default" prepend-icon="mdi-plus" variant="tonal" color="blue-darken-4" type="submit" >Añadir pais 
              <v-progress-circular
                color="primary"
                indeterminate
                size="20"
                v-if="loading"
              ></v-progress-circular>
            </v-btn>
          </v-col>
        </v-row>
        <v-row>
          <v-col cols="12" >
            <v-table v-if="countries.length > 0" >
              <thead>
                <tr>
                  <th class="text-left">Nombre</th>
                  <th class="text-left">Capital</th>
                  <th class="text-left">Region</th>
                  <th class="text-left">Subregion</th>
                  <th class="text-left">Poblacion</th>
                  <th class="text-left">Area</th>
                  <th class="text-left">Continente</th>
                  <th class="text-left">Bandera</th>
                  <th class="text-left">Operaciones</th>
                </tr>
              </thead>  
              <tbody>
                <tr v-for="country in countries" :key="country.id">
                  <td>{{ country.name }}</td>
                  <td>{{ country.capital }}</td>
                  <td>{{ country.region }}</td>
                  <td>{{ country.subregion }}</td>
                  <td>{{ country.population }}</td>
                  <td>{{ country.area }}</td>
                  <td>{{ country.continent }}</td>
                  <td> <img :src="country.flag" width="50" /></td>
                  <td> 
                    <v-btn density="default" prepend-icon="mdi-pencil" variant="tonal" color="blue-darken-4" v-tooltip="'Editar pais'" 
                      @click="callEditModal(country)"
                    ></v-btn>
                    
                    <v-btn density="default" prepend-icon="mdi-delete" variant="tonal" color="red-darken-4" v-tooltip="'Eliminar país'"
                     @click="callDeleteModal(country)" ></v-btn>
                  </td>
                </tr>  
              </tbody> 
            </v-table>
            <p v-else>Todavbia no has introducido ningun pais.</p>
          </v-col>
        </v-row>
      </v-form>
      <!-- Modal para elimar un pais -->
      <v-dialog v-model="deleteModalOpen" width="auto">
        <v-card>
          <v-card-title class="headline">Confirmar Eliminación</v-card-title>
          <v-card-text>
            ¿Estás seguro de que deseas eliminar el país {{ this.countryToDelete.name }} ?
          </v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="red" @click="deleteCountry(this.countryToDelete.id)">Eliminar</v-btn>
            <v-btn @click="closeDeleteModal">Cancelar</v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
      <!-- Modal para editar un pais -->
      <v-dialog v-model="editModalOpen">
        <v-card>
          <v-card-title>
            <span class="headline">Editando el pais: {{this.originalNameCountry}} </span>
          </v-card-title>
          <v-card-text>
            <v-form @submit.prevent="saveEditModal">
              <v-row>
                <v-col cols="12" md="2">
                  <v-text-field
                  v-model="this.countryToEdit.name"
                  label="Nombre"
                  ></v-text-field>
                </v-col>
                <v-col cols="12" md="2">
                  <v-text-field
                  v-model="this.countryToEdit.capital"
                  label="Capital"
                  ></v-text-field>
                </v-col>
                <v-col cols="12" md="2">
                  <v-text-field
                  v-model="this.countryToEdit.region"
                  label="Region"
                  ></v-text-field>
                </v-col>
                <v-col cols="12" md="2">
                  <v-text-field
                  v-model="this.countryToEdit.subregion"
                  label="Subregion"
                  ></v-text-field>
                </v-col>
                <v-col cols="12" md="2">
                  <v-text-field
                  v-model="this.countryToEdit.continent"
                  label="Continente"
                  ></v-text-field>
                </v-col>
                <v-col cols="12" md="2">
                  <v-text-field
                  v-model="this.countryToEdit.area"
                  label="Area"
                  type="number"
                  ></v-text-field>
                </v-col>
                <v-col cols="12" md="2">
                  <v-text-field
                  v-model="this.countryToEdit.population"
                  label="Población"
                  type="number"
                ></v-text-field>
                </v-col>
              </v-row>
            </v-form>
           </v-card-text>
           <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="red darken-1" text @click="closeModalEdit">Cancelar</v-btn>
            <v-btn color="blue darken-1" text @click="saveEditModal" prepend-icon="mdi-upload" >Guardar</v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
    </v-card-text>
  </v-card>
</v-container>

</template>

<script>
import { toast } from 'vue3-toastify';
import axios from "axios";

export default {
  name: 'app',
  components: {
    
  },
  data() {
    return {
      country:"",
      countries: [],
      deleteModalOpen: false,
      countryToDelete: {},
      loading: false,
      editModalOpen: false,
      countryToEdit: {},
      originalNameCountry: "",
    }
  },
  mounted() {
    this.countries = window.countries;
  },
  methods: {
    addCountry(){
      this.loading = true
      if(!this.country){
        toast.error("Debes introducir el nombre de un país"); 
        this.loading = false
        return
      }  
      console.log(this.country);
      axios.post(`/addCountry/${this.country}`)
      .then(response => {
        if(response.data.exists == "true"){
          toast.info(response.data.message);
          this.country = "";
          this.loading = false;
        }else{
          this.countries.push(response.data.country);
          this.country = "";
          this.loading = false;
          toast.success(response.data.message);
        }
      })
      .catch(error => {
        if(error.response){
          toast.error(error.response.data.message);
          this.loading = false;
        }
      })
    },
    callDeleteModal(country) {
      this.deleteModalOpen = true;
      this.countryToDelete = country;
    },
    closeDeleteModal() {
      this.deleteModalOpen = false;
    },
    deleteCountry(countryId) {
      axios.delete(`/deleteCountry/${countryId}`)
      .then(response => {
        if(response.data.exists == "true"){
          toast.info(response.data.message);
        }else{
          const index = this.countries.findIndex(index => index.id === countryId);
          if(index !== -1){
            this.countries.splice(index, 1);
          }
          this.closeDeleteModal();
          toast.success(response.data.message);
        }
      })
      this.closeDeleteModal();
    },
    callEditModal(country) {
      this.countryToEdit = {...country};
      this.originalNameCountry = this.countryToEdit.name;
      this.editModalOpen = true;
    },
    closeModalEdit() {
      this.editModalOpen = false;
    },
    saveEditModal() {
      const index = this.countries.findIndex(country => country.id === this.countryToEdit.id);
      if(index !== -1){
        axios.put(`/editCountry/${this.countryToEdit.id}`, this.countryToEdit)
        .then(response => {
          if(response.data.exists == "true"){
            toast.info(response.data.message);
          }else if(response.data.data){
            toast.error(response.data.message);
          }else{
            this.countries[index] = this.countryToEdit;
            this.closeModalEdit();
            toast.success(response.data.message);
          }
        })
        .catch(error => {
          if(error.response){
            toast.error(error.response.data.message);
          }
        })
      }
    }
  }
};
</script>

<style scoped>

</style>