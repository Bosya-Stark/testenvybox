<template>
  <div class="home">
    <span v-for="item in formState" :key="item.name">
      <input v-if="item.type === 'input'"
             type="text"
             :placeholder="'place input'"
             :name="item.name"
             v-model="item.value"
      >
    <textarea v-else-if="item.type === 'textarea'"
      cols="50"
      name="description"
      placeholder="place input description"
      v-model="item.value" />
    </span>
  </div>
  <button @click="onHandleSubmit">Submit</button>
  <br>
  <br>
  <span v-for="item in errors" :key="item">{{ item[0] }}<br></span>
</template>

<script>
import { ref, onMounted } from 'vue';
import axios from 'axios';

export default {
  name: 'Home',
  setup() {
    const formState = ref({
      name: '',
      phone: '',
      description: '',
    });
    const errors = ref([]);
    onMounted(() => {
      axios.post(`${process.env.VUE_APP_LOCALE_URL}getFormFields`, formState.value).then(({ data }) => {
        formState.value = data;
      }, ({ response }) => {
        errors.value = response;
      });
    });
    const onHandleSubmit = () => {
      const formData = ref({});
      for (let i = 0; i < Object.keys(formState.value).length; i += 1) {
        const { value, name } = formState.value[i];
        formData.value[name] = value;
      }
      axios.post(`${process.env.VUE_APP_LOCALE_URL}formSave`, formData.value).then(() => {
        errors.value = [];
        for (let i = 0; i < Object.keys(formState.value).length; i += 1) {
          formState.value[i].value = '';
        }
        alert('success');
      }, ({ response: { data } }) => {
        errors.value = data;
      });
    };
    return {
      formState,
      onHandleSubmit,
      errors,
    };
  },
};
</script>
<style scoped>
  .home {
    display: flex;
    justify-content: center;
  }
  .home>span>input {
    margin: 10px;
    border: 1px solid teal;
    border-radius: 10px;
  }
  .home>span>textarea {
    margin: 10px;
    border: 1px solid teal;
    border-radius: 10px;
  }
  button {
    padding: 10px;
    border: 1px #2c3e50;
    border-radius: 10px;
    cursor: pointer;
  }
  span {
    color: #ff0000;
  }
</style>
