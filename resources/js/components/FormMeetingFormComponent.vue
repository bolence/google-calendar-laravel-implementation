<template>
    <form class="p-5">
        <div class="form-group mb-2">
            <label for="name">Candidate full name</label>
            <input
                type="text"
                class="form-control"
                id="name"
                :class="{
                    'is-invalid': errors.name,
                }"
                placeholder="Enter candidate name"
            />
            <small v-if="errors.name" class="form-text text-danger"
                >{{ errors.name[0] }}
            </small>
        </div>
        <div class="form-group mb-2">
            <label for="phone">Candidate phone</label>
            <input
                v-model="phone"
                type="phone"
                class="form-control"
                :class="{
                    'is-invalid': errors.phone,
                }"
                id="phone"
                placeholder="Enter candidate phone"
            />
            <small v-if="errors.phone" class="form-text text-danger"
                >{{ errors.phone[0] }}
            </small>
        </div>
        <div class="form-group mb-2">
            <label for="email">Candidate email</label>
            <input
                v-model="phone"
                type="email"
                class="form-control"
                :class="{
                    'is-invalid': errors.email,
                }"
                id="email"
                placeholder="Enter candidate email"
            />
            <small v-if="errors.email" class="form-text text-danger"
                >{{ errors.email[0] }}
            </small>
        </div>
        <div class="form-group mb-2">
            <label for="time">Time</label>
            <input
                v-model="time"
                type="text"
                class="form-control"
                :class="{
                    'is-invalid': errors.time,
                }"
                id="time"
                placeholder="Meeting time"
            />
            <small v-if="errors.time" class="form-text text-danger"
                >{{ errors.time[0] }}
            </small>
        </div>

        <div class="form-group mb-2">
            <label for="date">Date</label>
            <input
                v-model="date"
                type="text"
                class="form-control"
                :class="{
                    'is-invalid': errors.date,
                }"
                id="date"
                placeholder="Meeting date"
            />
            <small v-if="errors.date" class="form-text text-danger"
                >{{ errors.date[0] }}
            </small>
        </div>

        <button
            class="btn btn-primary float-end"
            @click.prevent="makeMeeting()"
        >
            Submit
        </button>
    </form>
</template>

<script>
export default {
    data() {
        return {
            name: null,
            phone: null,
            email: null,
            time: null,
            date: null,
            errors: {},
        };
    },

    methods: {
        makeMeeting() {
            axios
                .post("/api/meetings")
                .then((resp) => {})
                .catch((error) => {
                    this.errors = error.response.data.errors;
                });
        },
    },
};
</script>
