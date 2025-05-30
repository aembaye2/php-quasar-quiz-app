<template>
  <q-page padding class="flex flex-col items-center">
    <div class="row items-center justify-center q-col-gutter-md" style="max-width: 600px; width: 100%;">
      <q-input
        filled
        v-model="newTodo"
        label="Add a task"
        @keyup.enter="addTodo"
        class="col-12 col-md-9"
        clearable
      />
      <q-btn
        label="Add"
        color="primary"
        :disable="!newTodo.trim() || loading"
        class="col-12 col-md-3"
        @click="addTodo"
      />
    </div>

    <q-list bordered class="q-mt-md" style="max-width: 600px; width: 100%;">
      <q-item v-for="todo in todos" :key="todo.id">
        <q-item-section avatar>
          <q-checkbox v-model="todo.done" @update:model-value="toggleDone(todo)" />
        </q-item-section>
        <q-item-section>
          <span :class="{ 'text-strike text-grey': todo.done }">
            {{ todo.text }}
          </span>
        </q-item-section>
        <q-item-section side>
          <q-btn flat icon="delete" color="red" @click="deleteTodo(todo.id)" />
        </q-item-section>
      </q-item>
      <q-item v-if="todos.length === 0" class="justify-center text-grey-6">
        No todos yet. Add one above!
      </q-item>
    </q-list>
  </q-page>
</template>


<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const todos = ref([]);
const newTodo = ref('');
const loading = ref(false);

// Replace with your actual Codespaces backend URL
const apiUrl = 'https://opulent-system-4j74rpgpx9xp35w7q-8000.app.github.dev/backend/todos.php';

const fetchTodos = async () => {
  try {
    loading.value = true;
    const res = await axios.get(apiUrl);
    todos.value = res.data;
  } catch (e) {
    console.error(e);
  } finally {
    loading.value = false;
  }
};

const addTodo = async () => {
  if (!newTodo.value.trim()) return;
  try {
    await axios.post(apiUrl, { text: newTodo.value.trim() });
    newTodo.value = '';
    await fetchTodos();
  } catch (e) {
    console.error(e);
  }
};

const deleteTodo = async (id) => {
  try {
    await axios.delete(`${apiUrl}?id=${id}`);
    await fetchTodos();
  } catch (e) {
    console.error(e);
  }
};

const toggleDone = async (todo) => {
  try {
    await axios.put(`${apiUrl}?id=${todo.id}`, { done: todo.done });
  } catch (e) {
    console.error(e);
  }
};

onMounted(fetchTodos);

</script>

<style scoped>
.text-line-through {
  text-decoration: line-through;
}
</style>

