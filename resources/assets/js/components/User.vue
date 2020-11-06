<template>
  <main class="main">
    <!-- Breadcrumb -->
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="/">Escritorio</a>
      </li>
    </ol>
    <div class="container-fluid">
      <!-- Ejemplo de tabla Listado -->
      <div class="card">
        <div class="card-header">
          <i class="fa fa-align-justify"></i> Usuarios
          <button
            type="button"
            @click="abrirModal('persona','registrar')"
            class="btn btn-secondary"
          >
            <i class="icon-plus"></i>&nbsp;Nuevo
          </button>
        </div>
        <div class="card-body">
          <div class="form-group row">
            <div class="col-md-6">
              <div class="input-group">
                <select class="form-control col-md-3" v-model="criterio">
                  <option value="nombre">Nombre</option>
                  <option value="num_documento">Documento</option>
                  <option value="email">Email</option>
                  <option value="telefono">Teléfono</option>
                </select>
                <input
                  type="text"
                  v-model="buscar"
                  @keyup.enter="listarPersona(1,buscar,criterio)"
                  class="form-control"
                  placeholder="Texto a buscar"
                />
                <button
                  type="submit"
                  @click="listarPersona(1,buscar,criterio)"
                  class="btn btn-primary"
                >
                  <i class="fa fa-search"></i> Buscar
                </button>
              </div>
            </div>
          </div>
          <table class="table table-bordered table-striped table-sm">
            <thead>
              <tr class="p-3 mb-2 bg-dark text-white">
                <th>Nombre</th>
                <th>Tipo Documento</th>
                <th>Número</th>
                <th>Dirección</th>
                <th>Teléfono</th>
                <th>Email</th>
                <th>Usuario</th>
                <th>Rol</th>
                <th>Opciones</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="persona in arrayPersona" :key="persona.id">
                <td v-text="persona.nombreFull"></td>
                <td v-text="persona.tp_doc"></td>
                <td v-text="persona.num_doc"></td>
                <td v-text="persona.direccion"></td>
                <td v-text="persona.telefono"></td>
                <td v-text="persona.email"></td>
                <td v-text="persona.usuario"></td>
                <td v-text="persona.rol"></td>
                <td>
                  <md-button
                    class="md-icon-button"
                    @click="abrirModal('persona','actualizar',persona)"
                    title="Actualizar"
                  >
                    <i class="material-icons ColorGreen">edit</i>
                  </md-button>
                  <md-button
                    class="md-icon-button"
                    @click="abrirModal2(persona)"
                    title="Actualizar"
                  >
                    <i class="material-icons ColorBlack">vpn_key</i>
                  </md-button>

                  <template v-if="persona.condicion">
                    <md-button
                      class="md-icon-button"
                      @click="desactivarUsuario(persona.id)"
                      title="Desactivar"
                    >
                      <i class="material-icons ColorRed">delete</i>
                    </md-button>
                  </template>
                  <template v-else>
                    <md-button
                      class="md-icon-button"
                      @click="activarUsuario(persona.id)"
                      title="Desactivar"
                    >
                      <i class="material-icons ColorGreen">done</i>
                    </md-button>
                  </template>
                </td>
              </tr>
            </tbody>
          </table>
          <nav>
            <ul class="pagination">
              <li class="page-item" v-if="pagination.current_page > 1">
                <a
                  class="page-link"
                  href="#"
                  @click.prevent="cambiarPagina(pagination.current_page - 1,buscar,criterio)"
                >Ant</a>
              </li>
              <li
                class="page-item"
                v-for="page in pagesNumber"
                :key="page"
                :class="[page == isActived ? 'active' : '']"
              >
                <a
                  class="page-link"
                  href="#"
                  @click.prevent="cambiarPagina(page,buscar,criterio)"
                  v-text="page"
                ></a>
              </li>
              <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                <a
                  class="page-link"
                  href="#"
                  @click.prevent="cambiarPagina(pagination.current_page + 1,buscar,criterio)"
                >Sig</a>
              </li>
            </ul>
          </nav>
        </div>
      </div>
      <!-- Fin ejemplo de tabla Listado -->
    </div>
    <!--Inicio del modal agregar/actualizar-->
    <div
      class="modal fade"
      tabindex="-1"
      :class="{'mostrar' : modal}"
      role="dialog"
      aria-labelledby="myModalLabel"
      style="display: none;"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-primary modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" v-text="tituloModal"></h4>
            <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            <form action method="post" enctype="multipart/form-data" class="form-horizontal">
              <div class="form-group row">
                <label class="col-md-3 form-control-label" for="text-input">Nombres(*)</label>
                <div class="col">
                  <input
                    type="text"
                    v-model="nombre"
                    class="form-control"
                    placeholder="Nombres de la persona"
                  />
                </div>
                <!-- <label class="col-md-3 form-control-label" for="text-input">Apellidos(*)</label> -->
                <div class="col">
                  <input
                    type="text"
                    v-model="apellido"
                    class="form-control"
                    placeholder="Apellidos de la persona"
                  />
                </div>
              </div>
           
              <div class="form-group row">
                <label class="col-md-3 form-control-label" for="text-input">Tipo documento</label>
                <div class="col">
                  <select v-model="tipo_documento" class="form-control">
                    <option value="CC">CEDULA</option>
                    <option value="DNI">NIT</option>
                    <option value="RUC">RUT</option>
                    <option value="PASS">PASS</option>
                  </select>
                </div>
                <div class="col">
                  <input
                    type="email"
                    v-model="num_documento"
                    class="form-control"
                    placeholder="Número de documento"
                  />
                </div>
              </div>
              <!-- <div class="form-group row">
                <label class="col-md-3 form-control-label" for="email-input">Número documento</label>
                <div class="col-md-9">
                  <input
                    type="email"
                    v-model="num_documento"
                    class="form-control"
                    placeholder="Número de documento"
                  />
                </div>
              </div> -->
              <div class="form-group row">
                <label class="col-md-3 form-control-label" for="email-input">Dirección</label>
                <div class="col-md-9">
                  <input
                    type="email"
                    v-model="direccion"
                    class="form-control"
                    placeholder="Dirección"
                  />
                </div>
              </div>
              <div class="form-group row">
                <label class="col-md-3 form-control-label" for="email-input">Teléfono</label>
                <div class="col-md-9">
                  <input
                    type="email"
                    v-model="telefono"
                    class="form-control"
                    placeholder="Teléfono"
                  />
                </div>
              </div>
              <div class="form-group row">
                <label class="col-md-3 form-control-label" for="email-input">Email</label>
                <div class="col-md-9">
                  <input type="email" v-model="email" class="form-control" placeholder="Email" />
                </div>
              </div>
              <div class="form-group row">
                <label class="col-md-3 form-control-label" for="email-input">Role</label>
                <div class="col-md-9">
                  <select v-model="idrol" class="form-control">
                    <option value="0" disabled>Seleccione</option>
                    <option
                      v-for="role in arrayRol"
                      :key="role.id"
                      :value="role.id"
                      v-text="role.nombre"
                    ></option>
                  </select>
                </div>
              </div>
              <div class="form-group row">
                    <label class="col-md-3 form-control-label" for="email-input">Usuario</label>
                    <div class="col-md-9">
                        <input type="text" v-model="usuario" class="form-control" placeholder="Nombre del usuario">
                    </div>
                </div>
                                <!-- <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="email-input">password</label>
                                    <div class="col-md-9">
                                        <input type="password" v-model="password" class="form-control" placeholder="password del usuario">
                                    </div> -->
              <!-- </div> -->
              <div v-show="errorPersona" class="form-group row div-error">
                <div class="text-center text-error">
                  <div v-for="error in errorMostrarMsjPersona" :key="error" v-text="error"></div>
                </div>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
            <button
              type="button"
              v-if="tipoAccion==1"
              class="btn btn-primary"
              @click="registrarPersona()"
            >Guardar</button>
            <button
              type="button"
              v-if="tipoAccion==2"
              class="btn btn-primary"
              @click="actualizarPersona()"
            >Actualizar</button>
          </div>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <!--Fin del modal-->
     <div
      class="modal fade"
      tabindex="-1"
      :class="{'mostrar' : modal2}"
      role="dialog"
      aria-labelledby="myModalLabel"
      style="display: none;"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-dark modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" v-text="tituloModal"></h4>
            <button type="button" class="close" @click="cerrarModal2()" aria-label="Close">
              <span aria-hidden="true">X</span>
            </button>
          </div>
          <div class="modal-body">
            <form action method="post" enctype="multipart/form-data" class="form-horizontal">
              <md-card-content>
                <md-field>
                <label>Password</label>
                <md-input v-model="password" type="password" :disabled="sending"></md-input>
                </md-field>

                <md-field>
                <label>Confirme su Password</label>
                <md-input v-model="password2" type="password" :disabled="sending"></md-input>
                </md-field>
                <span
                class="md-error"
                v-if="!$v.password2.sameAspassword2"
                >El password NO coincide</span>
              </md-card-content>
            </form>
          </div>
          <div class="modal-footer">
            <md-card-actions>
              <md-button type="button" class="md-raised" @click="cerrarModal2()">Cerrar</md-button>
            </md-card-actions>
            <md-card-actions>
              <md-button
                type="submit"               
                class="md-dense md-raised md-primary"
                :disabled="sending"
                @click="actualizarPw()"
              >Actualizar</md-button>
            </md-card-actions>

          </div>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <!--Fin del modal-->
  </main>
</template>

<script>
import { validationMixin } from "vuelidate";
import { sameAs } from "vuelidate/lib/validators";
export default {
     mixins: [validationMixin],
  data() {
    return {
      persona_id: 0,
      sending: false,
      nombre: "",
      apellido: "",
      tipo_documento: "",
      num_documento: "",
      direccion: "",
      telefono: "",
      email: "",
      usuario: "",
      password: "",
      password2: "",
      idrol: "",
      arrayPersona: [],
      arrayRol: [],
      modal: 0,
      modal2: 0,
      tituloModal: "",
      tipoAccion: 0,
      errorPersona: 0,
      errorMostrarMsjPersona: [],
      pagination: {
        total: 0,
        current_page: 0,
        per_page: 0,
        last_page: 0,
        from: 0,
        to: 0
      },
      offset: 3,
      criterio: "nombre",
      buscar: ""
    };
  },
  computed: {
    isActived: function() {
      return this.pagination.current_page;
    },
    //Calcula los elementos de la paginación
    pagesNumber: function() {
      if (!this.pagination.to) {
        return [];
      }

      var from = this.pagination.current_page - this.offset;
      if (from < 1) {
        from = 1;
      }

      var to = from + this.offset * 2;
      if (to >= this.pagination.last_page) {
        to = this.pagination.last_page;
      }

      var pagesArray = [];
      while (from <= to) {
        pagesArray.push(from);
        from++;
      }
      return pagesArray;
    }
  },
    validations: {
      password2: {
        sameAspassword2: sameAs("password")
      }
  },
  methods: {
    listarPersona(page, buscar, criterio) {
      let me = this;
      var url =
        "/user?page=" + page + "&buscar=" + buscar + "&criterio=" + criterio;
      axios
        .get(url)
        .then(function(response) {
          var respuesta = response.data;
          me.arrayPersona = respuesta.personas.data;
          me.pagination = respuesta.pagination;
        })
        .catch(function(error) {
          console.log(error);
        });
    },
    selectRol() {
      let me = this;
      var url = "/rol/selectRol";
      axios
        .get(url)
        .then(function(response) {
          //console.log(response);
          var respuesta = response.data;
          me.arrayRol = respuesta.roles;
        })
        .catch(function(error) {
          console.log(error);
        });
    },

    cambiarPagina(page, buscar, criterio) {
      let me = this;
      //Actualiza la página actual
      me.pagination.current_page = page;
      //Envia la petición para visualizar la data de esa página
      me.listarPersona(page, buscar, criterio);
    },
    registrarPersona() {
      if (this.validarPersona()) {
        return;
      }
      let me = this;
      axios
        .post("/user/registrar", {
          id: this.num_documento,
          nombre: this.nombre.toUpperCase(),
          tp_doc: this.tipo_documento,
          num_doc: this.num_documento,
          direccion: this.direccion,
          telefono: this.telefono,
          email: this.email.toUpperCase(),
          idrol: this.idrol,
          usuario: this.usuario,
          password: this.password
        })
        .then(function(response) {
          me.cerrarModal();
          me.listarPersona(1, "", "nombre");
        })
        .catch(function(error) {
          console.log(error);
        });
    },
    actualizarPersona() {
      if (this.validarPersona()) {
        return;
      }

      let me = this;

      axios
        .put("/user/actualizar", {
          id: this.num_documento,
          nombre: this.nombre.toUpperCase(),
          apellido: this.apellido.toUpperCase(),
          tipo_doc: this.tipo_documento,
          num_documento: this.num_documento,
          direccion: this.direccion,
          telefono: this.telefono,
          email: this.email.toUpperCase(),
          idrol: this.idrol,
          usuario: this.usuario,
          password: this.password,
          id: this.persona_id
        })
        .then(function(response) {
          me.cerrarModal();
          me.listarPersona(1, "", "nombre");
        })
        .catch(function(error) {
          console.log(error);
        });
    },
    actualizarPw() {
      let me = this;

      axios
        .put("/user/actualizarPw", {
          id: this.num_documento,
          password: this.password
        
        })
        .then(function(response) {
          me.cerrarModal();
          me.mensaje("Actualizado", "Actualizó ");
          me.listarPersona(1, "", "nombre");
        })
        .catch(function(error) {
          console.log(error);
        });
    },
    validarPersona() {
      this.errorPersona = 0;
      this.errorMostrarMsjPersona = [];

      if (!this.nombre)
        this.errorMostrarMsjPersona.push(
          "El nombre de la pesona no puede estar vacío."
        );
      if (!this.usuario)
        this.errorMostrarMsjPersona.push(
          "El nombre de usuario no puede estar vacío."
        );
    //   if (!this.password)
    //     this.errorMostrarMsjPersona.push(
    //       "La password del usuario no puede estar vacía."
    //     );
      if (this.idrol == 0)
        this.errorMostrarMsjPersona.push("Seleccione una Role.");
      if (this.errorMostrarMsjPersona.length) this.errorPersona = 1;

      return this.errorPersona;
    },
    cerrarModal() {
      this.modal = 0;
      this.tituloModal = "";
      this.nombre = "";
      this.tipo_documento = "cc";
      this.num_documento = "";
      this.direccion = "";
      this.telefono = "";
      this.email = "";
      this.usuario = "";
      this.password = "";
      this.idrol = 0;
      this.errorPersona = 0;
    },
    abrirModal(modelo, accion, data = []) {
      this.selectRol();
      switch (modelo) {
        case "persona": {
          switch (accion) {
            case "registrar": {
              this.modal = 1;
              this.tituloModal = "Registrar Usuario";
              this.nombre = "";
              this.apellido = "";
              this.tipo_documento = "cc";
              this.num_documento = "";
              this.direccion = "";
              this.telefono = "";
              this.email = "";
              this.usuario = "";
              this.password = "";
              this.idrol = 0;
              this.tipoAccion = 1;
              break;
            }
            case "actualizar": {
              //console.log(data);
              this.modal = 1;
              this.tituloModal = "Actualizar Usuario";
              this.tipoAccion = 2;
              this.persona_id = data["id"];
              this.nombre = data["nombres"];
              this.apellido = data["apellidos"];
              this.tipo_documento = data["tp_doc"];
              this.num_documento = data["num_doc"];
              this.direccion = data["direccion"];
              this.telefono = data["telefono"];
              this.email = data["email"];
              this.usuario = data["usuario"];
              this.password = data["password"];
              this.idrol = data["idrol"];
              break;
            }
          }
        }
      }
    },
    abrirModal2(data=[]) {
      // this.idRefE=data["idref"];
      this.num_documento=data["id"];
      this.modal2 = 1;
      this.tituloModal = "Asigne un Password para "+ data["nombreFull"];
    },
    cerrarModal2() {
      this.modal2 = 0;
      this.tituloModal = "";
    },
    mensaje(tipo, crud) {
    swal(tipo, "El registro se " + crud + " con éxito.", "success");
    },
    desactivarUsuario(id) {
      swal({
        title: "Esta seguro de desactivar este usuario?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Aceptar!",
        cancelButtonText: "Cancelar",
        confirmButtonClass: "btn btn-success",
        cancelButtonClass: "btn btn-danger",
        buttonsStyling: false,
        reverseButtons: true
      }).then(result => {
        if (result.value) {
          let me = this;

          axios
            .put("/user/desactivar", {
              id: id
            })
            .then(function(response) {
              me.listarPersona(1, "", "nombre");
              swal(
                "Desactivado!",
                "El registro ha sido desactivado con éxito.",
                "success"
              );
            })
            .catch(function(error) {
              console.log(error);
            });
        } else if (
          // Read more about handling dismissals
          result.dismiss === swal.DismissReason.cancel
        ) {
        }
      });
    },
    activarUsuario(id) {
      swal({
        title: "Esta seguro de activar este usuario?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Aceptar!",
        cancelButtonText: "Cancelar",
        confirmButtonClass: "btn btn-success",
        cancelButtonClass: "btn btn-danger",
        buttonsStyling: false,
        reverseButtons: true
      }).then(result => {
        if (result.value) {
          let me = this;

          axios
            .put("/user/activar", {
              id: id
            })
            .then(function(response) {
              me.listarPersona(1, "", "nombre");
              swal(
                "Activado!",
                "El registro ha sido activado con éxito.",
                "success"
              );
            })
            .catch(function(error) {
              console.log(error);
            });
        } else if (
          // Read more about handling dismissals
          result.dismiss === swal.DismissReason.cancel
        ) {
        }
      });
    }
  },
  mounted() {
    this.listarPersona(1, this.buscar, this.criterio);
  }
};
</script>
<style>
.modal-content {
  width: 100% !important;
  position: absolute !important;
}
.mostrar {
  display: list-item !important;
  opacity: 1 !important;
  position: absolute !important;
  background-color: #3c29297a !important;
}
.div-error {
  display: flex;
  justify-content: center;
}
.text-error {
  color: red !important;
  font-weight: bold;
}
.material-icons.ColorBlack {
  color: rgb(31, 33, 34);
}
.material-icons.ColorOrange {
  color: rgba(252, 125, 22, 0.849);
}
.material-icons.ColorGreen {
  color: rgb(12, 170, 91);
}
.material-icons.ColorRed {
  color: rgba(228, 54, 54, 0.863);
}
</style>
