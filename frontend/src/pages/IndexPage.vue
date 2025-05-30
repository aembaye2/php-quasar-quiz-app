<template>
  <q-page class="q-pa-md">
    <q-input filled v-model="newTodo" label="Add a task" @keyup.enter="addTodo" />
    <q-btn label="Add" color="primary" class="q-mt-sm" @click="addTodo" />

    <q-list bordered class="q-mt-md">
      <q-item v-for="todo in todos" :key="todo.id">
        <q-item-section>{{ todo.text }}</q-item-section>
        <q-item-section side>
          <q-btn flat icon="delete" color="red" @click="deleteTodo(todo.id)" />
        </q-item-section>
      </q-item>
    </q-list>
  </q-page>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const todos = ref([]);
const newTodo = ref('');
const apiUrl = 'http://localhost:8000/backend/todos.php';

const fetchTodos = async () => {
  const res = await axios.get(apiUrl);
  todos.value = res.data;
};

const addTodo = async () => {
  if (!newTodo.value.trim()) return;
  await axios.post(apiUrl, { text: newTodo.value });
  newTodo.value = '';
  fetchTodos();
};

const deleteTodo = async (id) => {
  await axios.delete(`${apiUrl}?id=${id}`);
  fetchTodos();
};

onMounted(fetchTodos);
</script>

