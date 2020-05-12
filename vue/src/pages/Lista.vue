<template>
<div>
      <h1 class="text-center">Lista de tarefas</h1>
      <h2 class="text-center">{{ message }}</h2>
      <b-btn class="btn-sm btn-green" @click="modalShowCadastro = !modalShowCadastro">Nova Tarefa</b-btn>
      <b-row>
            <b-col>
                  <h2>Em espera</h2>
				<div id="accordion" class="accordion" v-for="item in tasks" :key="item">
					<b-card class="bg-dark text-white" no-body v-if="item.status === 2">
						<b-card-header header-tag="header" class="card-header bg-dark-darker text-white pointer-cursor" v-b-toggle.accordion2>
							<i class="fa fa-circle fa-fw text-grey mr-2 f-s-8"></i> <b>{{ item.task }}</b> 
                                          <b-btn-group class="ml-4">
                                                <b-btn class="btn-sm btn-warning" @click="showModal(item);modalShow = !modalShow">Editar</b-btn>
                                                <b-btn class="btn-sm btn-danger" v-on:click="deletar(item.id)">Deletar</b-btn>
                                                <b-btn class="btn-sm btn-success" v-on:click="alterarStatus(1, item)">Andamento</b-btn>
                                                <b-btn class="btn-sm btn-green" v-on:click="alterarStatus(0, item)">Finalizar</b-btn>
                                          </b-btn-group>
						</b-card-header>
						<b-collapse id="accordion2" visible accordion="my-accordion2">
							<b-card-body>
								{{ item.description }}
							</b-card-body>
						</b-collapse>
					</b-card>
				</div>
            </b-col>
            <b-col>
                  <h2>Em andamento</h2>
                  	<div id="accordion" class="accordion" v-for="item in tasks" :key="item">
					<b-card class="bg-dark text-white" no-body v-if="item.status === 1">
						<b-card-header header-tag="header" class="card-header bg-dark-darker text-white pointer-cursor" v-b-toggle.accordion1>
							<i class="fa fa-circle fa-fw text-blue mr-2 f-s-8"></i> <b>{{ item.task }}</b>
                                          <b-btn-group class="ml-4">
                                                <b-btn class="btn-sm btn-warning" @click="showModal(item);modalShow = !modalShow">Editar</b-btn>
                                                <b-btn class="btn-sm btn-danger" v-on:click="deletar(item.id)">Deletar</b-btn>
                                                <b-btn class="btn-sm btn-primary" v-on:click="alterarStatus(2, item)">Em espera</b-btn>
                                                <b-btn class="btn-sm btn-green" v-on:click="alterarStatus(0, item)">Finalizar</b-btn>
                                          </b-btn-group>
						</b-card-header>
						<b-collapse id="accordion1" visible accordion="my-accordion1">
							<b-card-body>
								{{ item.description }}
							</b-card-body>
						</b-collapse>
					</b-card>
				</div>
            </b-col>
            <b-col>
                  <h2>Finalizadas</h2>
                  	<div id="accordion" class="accordion" v-for="item in tasks" :key="item">
					<b-card class="bg-dark text-white" no-body v-if="item.status === 0">
						<b-card-header header-tag="header" class="card-header bg-dark-darker text-white pointer-cursor" v-b-toggle.accordion0>
							<i class="fa fa-circle fa-fw text-green mr-2 f-s-8"></i> <b>{{ item.task }}</b>
                                          <b-btn-group class="ml-4">
                                                <b-btn class="btn-sm btn-warning" @click="showModal(item);modalShow = !modalShow">Editar</b-btn>
                                                <b-btn class="btn-sm btn-danger" v-on:click="deletar(item.id)">Deletar</b-btn>
                                                <b-btn class="btn-sm btn-primary" v-on:click="alterarStatus(2, item)">Em espera</b-btn>
                                                <b-btn class="btn-sm btn-success" v-on:click="alterarStatus(1, item)">Andamento</b-btn>
                                          </b-btn-group>
                                    </b-card-header>
						<b-collapse id="accordion0" visible accordion="my-accordion0">
							<b-card-body>
								{{ item.description }}
							</b-card-body>
						</b-collapse>
					</b-card>
				</div>
            </b-col>
      </b-row>
      <b-modal v-model="modalShow" cancel-variant="default" title="Tarefa em espera">
            <small>Tarefa</small>
            <input type="text" class="form-control" v-model="itemModalTask" />
            <small>Descrição</small>
            <input type="text" class="form-control" v-model="itemModalDescription" />
            <template v-slot:modal-footer="{ ok, cancel }">
                  <b-button size="sm" variant="success" @click="alterar(itemModalId, itemModalTask, itemModalDescription, itemModalStatus)">
                        Salvar Alterações
                  </b-button>
                  <b-button size="sm" variant="danger" @click="cancel()">
                        Cancelar
                  </b-button>
            </template>
      </b-modal>
      <b-modal v-model="modalShowCadastro" cancel-variant="default" title="Tarefa em espera">
            <small>Tarefa</small>
            <input type="text" class="form-control" v-model="newTask.task" />
            <small>Descrição</small>
            <input type="text" class="form-control" v-model="newTask.description" />
            <template v-slot:modal-footer="{ ok, cancel }">
                  <b-button v-if="newTask.task != ''" size="sm" variant="success" @click="cadastrar(newTask)">
                        Salvar Cadastro
                  </b-button>
                  <b-button size="sm" variant="danger" @click="cancel()">
                        Cancelar
                  </b-button>
            </template>
      </b-modal>
</div>
</template>
<script>
import Received from '../services/tasks';
export default {
      data() {
            return {
                  tasks: null,
                  newTask: {
                        task: '',
                        description: '',
                        status: 2
                  },
                  modalShowCadastro: false,
                  modalShow: false,
                  itemModalId: null,
                  itemModalTask: null,
                  itemModalDescription: null,
                  itemModalStatus: null,
                  message: ''
            }
      },
      mounted () {
            this.lista()
      },
      methods: {
            showModal(item) {
                  this.itemModalId = item.id
                  this.itemModalTask = item.task
                  this.itemModalDescription = item.description
                  this.itemModalStatus = item.status
            },
            lista() {
                        Received.listar().then(response => {
                              this.tasks = response.data.data
                              if (response.data.data.length === 0) {
                                    this.message = 'Crie tarefas, você não possuí nenhuma.'
                              } else if (response.data.data.length > 0) {
                                    this.message = ''
                              }
                        })
                        .catch(e => {
                              console.log(e)
                              this.message = 'Ops, aconteceu algo de errado, recarregue a página.'
                        })
            },
            deletar(task) {
                        Received.deletar(task).then(response => {
                              this.lista()
                        })
                        .catch(e => {
                              console.log(e)
                        })
		},
            alterar(id, task, description, itemModalStatus) {
                        var data = new Object;
                        data.task = task;
                        data.description = description;
                        data.status = itemModalStatus;
                        Received.alterar(id, data).then(response => {
                              this.lista()
                              this.modalShow = false
                        })
                        .catch(e => {
                              console.log(e)
                        })
		},
            cadastrar(data) {
                        Received.cadastrar(data).then(response => {
                              this.lista()
                              this.modalShowCadastro = false
                        })
                        .catch(e => {
                              console.log(e)
                        })
            },
            alterarStatus(status, task) {
                        var data = new Object;
                        data.task = task.task;
                        data.description = task.description;
                        data.status = status;
                        Received.alterar(task.id, data).then(response => {
                              this.lista()
                        })
                        .catch(e => {
                              console.log(e)
                        })
		}
      }
}
</script>