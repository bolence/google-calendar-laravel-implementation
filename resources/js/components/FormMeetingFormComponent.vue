<template>
<fragment>

        <div class="float-end mt-3">
            <a class="btn btn-primary" href="/google/auth/callback">
                Login with Google
            </a>
        </div>
    <form class="p-5 mt-5">
        <div class="alert alert-success" role="alert" v-if="success_message">
            <strong>{{ success_message }}</strong>
        </div>
        <div class="alert alert-danger" role="alert" v-if="error_message">
            <strong>{{ error_message }}</strong>
        </div>
        <div class="form-group mb-2">
            <label for="name">Event name</label>
            <input
                type="text"
                class="form-control"
                id="name"
                v-model="event.name"
                :class="{
                    'is-invalid': errors?.name,
                }"
                placeholder="Event name"
            />
            <small v-if="errors?.name" class="form-text text-danger"
                >{{ errors.name[0] }}
            </small>
        </div>
        <div class="form-group mb-2">
            <label for="phone">Candidate phone</label>
            <input
                v-model="event.phone"
                type="phone"
                class="form-control"
                :class="{
                    'is-invalid': errors?.phone,
                }"
                id="phone"
                placeholder="Enter candidate phone"
            />
            <small v-if="errors?.phone" class="form-text text-danger"
                >{{ errors.phone[0] }}
            </small>
        </div>
        <div class="form-group mb-2">
            <label for="email">Candidate email</label>
            <input
                v-model="event.email"
                type="email"
                class="form-control"
                :class="{
                    'is-invalid': errors?.email,
                }"
                id="email"
                placeholder="Enter candidate email"
            />
            <small v-if="errors?.email" class="form-text text-danger"
                >{{ errors.email[0] }}
            </small>
        </div>
        <div class="form-group mb-2">
            <label for="time">Time</label>

            <datePicker
                v-model="event.time"
                :class="{
                    'is-invalid': errors?.time,
                }"
                type="text"
                :config="timeOptions"
                placeholder="Meeting time"
            />
            <small v-if="errors?.time" class="form-text text-danger"
                >{{ errors.time[0] }}
            </small>
        </div>

        <div class="form-group mb-2">
            <label for="date">Date</label>
            <datePicker
                v-model="event.date"
                type="text"
                :class="{
                    'is-invalid': errors?.date,
                }"
                :config="dateOptions"
                placeholder="Meeting date"
                :min-date="new Date()"
            />

            <small v-if="errors?.date" class="form-text text-danger"
                >{{ errors.date[0] }}
            </small>
        </div>

        <div class="form-group mb-2">
            <label for="date">Note</label>
            <textarea
                class="form-control"
                name="note"
                id="note"
                rows="3"
                v-model="event.note"
            ></textarea>
        </div>

        <button
            class="btn btn-primary float-end"
            @click.prevent="makeMeeting()"
        >
            Create an event
        </button>
    </form>
    </fragment>
</template>

<script>
import datePicker from "vue-bootstrap-datetimepicker";

export default {
    components: {
        datePicker,
    },
    data() {
        return {
            event: {
                name: null,
                phone: null,
                email: null,
                time: null,
                date: null,
                note: null,
            },
            today: new Date(),
            timeOptions: {
                format: "h:mm a",
                stepping: 30,
            },
            dateOptions: {
                format: "DD/MM/YYYY",
                useCurrent: true,
                minDate: new Date(),
            },
            errors: {},
            success_message: null,
            error_message: null,
        };
    },

    methods: {
        makeMeeting() {
            this.success_message = null;
            this.error_message = null;
            axios
                .post("/google/calendar/event", this.event)
                .then((resp) => {
                    this.success_message = resp.data.message;
                    // this.event = {};
                })
                .catch((error) => {
                    this.error_message = error.response.data.message;
                    this.errors = error.response.data.errors;
                });
        },
    },
};
</script>
