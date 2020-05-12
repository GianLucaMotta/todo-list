import { http } from '../api/config'

export default	{
      listar:()=>{
            return http.get('/tasks')
      },
      cadastrar:(data)=>{
            return http.post('/task', data)
      },
      alterar:(task, data)=>{
            return http.put('/task/' + task, data)
      },
      deletar:(task)=>{
            return http.delete('/task/' + task)
      }
}