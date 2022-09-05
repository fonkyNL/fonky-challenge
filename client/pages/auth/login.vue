<template>
  <div class="min-h-full flex flex-col justify-center py-12 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
      <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">Sign in to your account</h2>
      <p class="mt-2 text-center text-sm text-gray-600">
        Or
        <BaseLink to="/">create an account</BaseLink>
      </p>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
      <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
        <div v-if="error" class="pb-5">
          <span class="text-red-400 text-sm"> {{ this.error }} </span>
        </div>

        <form class="space-y-6" action="#" method="POST" @submit.prevent="submit">
          <div>
            <label for="email" class="block text-sm font-medium text-gray-700"> Email address </label>
            <div class="mt-1">
              <BaseInputText type="email" id="email" v-model="form.email" autocapitalize="off" autocomplete="email" placeholder="youremail@example.com" />
            </div>
          </div>

          <div>
            <label for="password" class="block text-sm font-medium text-gray-700"> Password </label>
            <div class="mt-1">
              <BaseInputText type="password" id="password" v-model="form.password" autocapitalize="off" placeholder="********" />
            </div>
          </div>

          <div class="flex items-center">
            <div class="text-sm">
              <!-- <BaseLink to="/auth/reset">Forgot your password?</BaseLink> -->
            </div>
          </div>

          <div>
            <BaseButton type="submit">Sign in</BaseButton>
          </div>
        </form>

      </div>
    </div>
  </div>
</template>

<script>
import axios, { AxiosError } from 'axios'
import { $axios } from '@/utils/api'

export default {
  layout: 'basic',
  auth: 'guest',

  data() {
    return {
      form: {
        email: 'hello@fonky.nl',
        password: 'fonky123',
      },
      error: ''
    }
  },

  methods: {
    async submit() {
      try {
        const data = { 
          email: this.form.email, 
          password: this.form.password
        }

        await this.$auth.loginWith('laravelJWT', { data: data })
      } catch (serverError) {
        const error = serverError

        if (! axios.isAxiosError(error)){
          throw serverError
        }

        this.error = serverError.response.data.message
      }
    }
  }  
}
</script>