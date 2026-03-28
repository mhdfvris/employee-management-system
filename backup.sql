--
-- PostgreSQL database dump
--

\restrict ukdsWfo9fJqvJhJTX5Pn0hTkDocasxamGPdto5uS1y5CjhsLexrp5KGiY8vj2tS

-- Dumped from database version 16.13 (Ubuntu 16.13-0ubuntu0.24.04.1)
-- Dumped by pg_dump version 16.13 (Ubuntu 16.13-0ubuntu0.24.04.1)

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: cache; Type: TABLE; Schema: public; Owner: task_user
--

CREATE TABLE public.cache (
    key character varying(255) NOT NULL,
    value text NOT NULL,
    expiration integer NOT NULL
);


ALTER TABLE public.cache OWNER TO task_user;

--
-- Name: cache_locks; Type: TABLE; Schema: public; Owner: task_user
--

CREATE TABLE public.cache_locks (
    key character varying(255) NOT NULL,
    owner character varying(255) NOT NULL,
    expiration integer NOT NULL
);


ALTER TABLE public.cache_locks OWNER TO task_user;

--
-- Name: failed_jobs; Type: TABLE; Schema: public; Owner: task_user
--

CREATE TABLE public.failed_jobs (
    id bigint NOT NULL,
    uuid character varying(255) NOT NULL,
    connection text NOT NULL,
    queue text NOT NULL,
    payload text NOT NULL,
    exception text NOT NULL,
    failed_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL
);


ALTER TABLE public.failed_jobs OWNER TO task_user;

--
-- Name: failed_jobs_id_seq; Type: SEQUENCE; Schema: public; Owner: task_user
--

CREATE SEQUENCE public.failed_jobs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.failed_jobs_id_seq OWNER TO task_user;

--
-- Name: failed_jobs_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: task_user
--

ALTER SEQUENCE public.failed_jobs_id_seq OWNED BY public.failed_jobs.id;


--
-- Name: job_batches; Type: TABLE; Schema: public; Owner: task_user
--

CREATE TABLE public.job_batches (
    id character varying(255) NOT NULL,
    name character varying(255) NOT NULL,
    total_jobs integer NOT NULL,
    pending_jobs integer NOT NULL,
    failed_jobs integer NOT NULL,
    failed_job_ids text NOT NULL,
    options text,
    cancelled_at integer,
    created_at integer NOT NULL,
    finished_at integer
);


ALTER TABLE public.job_batches OWNER TO task_user;

--
-- Name: jobs; Type: TABLE; Schema: public; Owner: task_user
--

CREATE TABLE public.jobs (
    id bigint NOT NULL,
    queue character varying(255) NOT NULL,
    payload text NOT NULL,
    attempts smallint NOT NULL,
    reserved_at integer,
    available_at integer NOT NULL,
    created_at integer NOT NULL
);


ALTER TABLE public.jobs OWNER TO task_user;

--
-- Name: jobs_id_seq; Type: SEQUENCE; Schema: public; Owner: task_user
--

CREATE SEQUENCE public.jobs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.jobs_id_seq OWNER TO task_user;

--
-- Name: jobs_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: task_user
--

ALTER SEQUENCE public.jobs_id_seq OWNED BY public.jobs.id;


--
-- Name: migrations; Type: TABLE; Schema: public; Owner: task_user
--

CREATE TABLE public.migrations (
    id integer NOT NULL,
    migration character varying(255) NOT NULL,
    batch integer NOT NULL
);


ALTER TABLE public.migrations OWNER TO task_user;

--
-- Name: migrations_id_seq; Type: SEQUENCE; Schema: public; Owner: task_user
--

CREATE SEQUENCE public.migrations_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.migrations_id_seq OWNER TO task_user;

--
-- Name: migrations_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: task_user
--

ALTER SEQUENCE public.migrations_id_seq OWNED BY public.migrations.id;


--
-- Name: notifications; Type: TABLE; Schema: public; Owner: task_user
--

CREATE TABLE public.notifications (
    id uuid NOT NULL,
    type character varying(255) NOT NULL,
    notifiable_type character varying(255) NOT NULL,
    notifiable_id bigint NOT NULL,
    data text NOT NULL,
    read_at timestamp(0) without time zone,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.notifications OWNER TO task_user;

--
-- Name: password_reset_tokens; Type: TABLE; Schema: public; Owner: task_user
--

CREATE TABLE public.password_reset_tokens (
    email character varying(255) NOT NULL,
    token character varying(255) NOT NULL,
    created_at timestamp(0) without time zone
);


ALTER TABLE public.password_reset_tokens OWNER TO task_user;

--
-- Name: sessions; Type: TABLE; Schema: public; Owner: task_user
--

CREATE TABLE public.sessions (
    id character varying(255) NOT NULL,
    user_id bigint,
    ip_address character varying(45),
    user_agent text,
    payload text NOT NULL,
    last_activity integer NOT NULL
);


ALTER TABLE public.sessions OWNER TO task_user;

--
-- Name: task_activities; Type: TABLE; Schema: public; Owner: task_user
--

CREATE TABLE public.task_activities (
    id bigint NOT NULL,
    task_id bigint NOT NULL,
    actor_id bigint,
    action character varying(255) NOT NULL,
    meta json,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.task_activities OWNER TO task_user;

--
-- Name: task_activities_id_seq; Type: SEQUENCE; Schema: public; Owner: task_user
--

CREATE SEQUENCE public.task_activities_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.task_activities_id_seq OWNER TO task_user;

--
-- Name: task_activities_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: task_user
--

ALTER SEQUENCE public.task_activities_id_seq OWNED BY public.task_activities.id;


--
-- Name: task_reviews; Type: TABLE; Schema: public; Owner: task_user
--

CREATE TABLE public.task_reviews (
    id bigint NOT NULL,
    task_id bigint NOT NULL,
    manager_id bigint NOT NULL,
    comment text NOT NULL,
    decision character varying(255) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.task_reviews OWNER TO task_user;

--
-- Name: task_reviews_id_seq; Type: SEQUENCE; Schema: public; Owner: task_user
--

CREATE SEQUENCE public.task_reviews_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.task_reviews_id_seq OWNER TO task_user;

--
-- Name: task_reviews_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: task_user
--

ALTER SEQUENCE public.task_reviews_id_seq OWNED BY public.task_reviews.id;


--
-- Name: tasks; Type: TABLE; Schema: public; Owner: task_user
--

CREATE TABLE public.tasks (
    id bigint NOT NULL,
    user_id bigint NOT NULL,
    title character varying(255) NOT NULL,
    description text,
    status character varying(255) NOT NULL,
    due_date date NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.tasks OWNER TO task_user;

--
-- Name: tasks_id_seq; Type: SEQUENCE; Schema: public; Owner: task_user
--

CREATE SEQUENCE public.tasks_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.tasks_id_seq OWNER TO task_user;

--
-- Name: tasks_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: task_user
--

ALTER SEQUENCE public.tasks_id_seq OWNED BY public.tasks.id;


--
-- Name: users; Type: TABLE; Schema: public; Owner: task_user
--

CREATE TABLE public.users (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    email character varying(255) NOT NULL,
    email_verified_at timestamp(0) without time zone,
    password character varying(255) NOT NULL,
    remember_token character varying(100),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    role character varying(255) DEFAULT 'employee'::character varying NOT NULL,
    employee_id character varying(255),
    manager_id bigint
);


ALTER TABLE public.users OWNER TO task_user;

--
-- Name: users_id_seq; Type: SEQUENCE; Schema: public; Owner: task_user
--

CREATE SEQUENCE public.users_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.users_id_seq OWNER TO task_user;

--
-- Name: users_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: task_user
--

ALTER SEQUENCE public.users_id_seq OWNED BY public.users.id;


--
-- Name: failed_jobs id; Type: DEFAULT; Schema: public; Owner: task_user
--

ALTER TABLE ONLY public.failed_jobs ALTER COLUMN id SET DEFAULT nextval('public.failed_jobs_id_seq'::regclass);


--
-- Name: jobs id; Type: DEFAULT; Schema: public; Owner: task_user
--

ALTER TABLE ONLY public.jobs ALTER COLUMN id SET DEFAULT nextval('public.jobs_id_seq'::regclass);


--
-- Name: migrations id; Type: DEFAULT; Schema: public; Owner: task_user
--

ALTER TABLE ONLY public.migrations ALTER COLUMN id SET DEFAULT nextval('public.migrations_id_seq'::regclass);


--
-- Name: task_activities id; Type: DEFAULT; Schema: public; Owner: task_user
--

ALTER TABLE ONLY public.task_activities ALTER COLUMN id SET DEFAULT nextval('public.task_activities_id_seq'::regclass);


--
-- Name: task_reviews id; Type: DEFAULT; Schema: public; Owner: task_user
--

ALTER TABLE ONLY public.task_reviews ALTER COLUMN id SET DEFAULT nextval('public.task_reviews_id_seq'::regclass);


--
-- Name: tasks id; Type: DEFAULT; Schema: public; Owner: task_user
--

ALTER TABLE ONLY public.tasks ALTER COLUMN id SET DEFAULT nextval('public.tasks_id_seq'::regclass);


--
-- Name: users id; Type: DEFAULT; Schema: public; Owner: task_user
--

ALTER TABLE ONLY public.users ALTER COLUMN id SET DEFAULT nextval('public.users_id_seq'::regclass);


--
-- Data for Name: cache; Type: TABLE DATA; Schema: public; Owner: task_user
--

COPY public.cache (key, value, expiration) FROM stdin;
\.


--
-- Data for Name: cache_locks; Type: TABLE DATA; Schema: public; Owner: task_user
--

COPY public.cache_locks (key, owner, expiration) FROM stdin;
\.


--
-- Data for Name: failed_jobs; Type: TABLE DATA; Schema: public; Owner: task_user
--

COPY public.failed_jobs (id, uuid, connection, queue, payload, exception, failed_at) FROM stdin;
\.


--
-- Data for Name: job_batches; Type: TABLE DATA; Schema: public; Owner: task_user
--

COPY public.job_batches (id, name, total_jobs, pending_jobs, failed_jobs, failed_job_ids, options, cancelled_at, created_at, finished_at) FROM stdin;
\.


--
-- Data for Name: jobs; Type: TABLE DATA; Schema: public; Owner: task_user
--

COPY public.jobs (id, queue, payload, attempts, reserved_at, available_at, created_at) FROM stdin;
\.


--
-- Data for Name: migrations; Type: TABLE DATA; Schema: public; Owner: task_user
--

COPY public.migrations (id, migration, batch) FROM stdin;
1	0001_01_01_000000_create_users_table	1
2	0001_01_01_000001_create_cache_table	1
3	0001_01_01_000002_create_jobs_table	1
4	2025_11_18_072527_add_role_and_employee_id_to_users_table	2
5	2025_11_23_101148_create_tasks_table	3
6	2025_12_01_124416_add_manager_id_to_users_table	4
7	2025_12_19_085028_create_task_activities_table	5
8	2025_12_19_110153_create_task_reviews_table	6
9	2025_12_23_133158_create_notifications_table	7
\.


--
-- Data for Name: notifications; Type: TABLE DATA; Schema: public; Owner: task_user
--

COPY public.notifications (id, type, notifiable_type, notifiable_id, data, read_at, created_at, updated_at) FROM stdin;
4a01d422-c095-4575-8284-9076a69edfa8	App\\Notifications\\TaskOverdue	App\\Models\\User	2	{"type":"task_overdue","task_id":5,"title":"Update internal documentation","employee_id":6,"due_date":"2025-11-25"}	2025-12-23 14:08:19	2025-12-23 13:49:04	2025-12-23 14:08:19
7571b71c-08fd-40da-b9a5-e724acdf8123	App\\Notifications\\TaskOverdue	App\\Models\\User	2	{"type":"task_overdue","task_id":15,"title":"delete","employee_id":6,"due_date":"2025-02-11"}	2025-12-23 14:08:19	2025-12-23 13:49:04	2025-12-23 14:08:19
c73c806e-67d1-4a6f-9269-14c8d574aa11	App\\Notifications\\TaskAwaitingReview	App\\Models\\User	2	{"type":"task_awaiting_review","task_id":14,"title":"ddd","employee_id":1,"due_date":"2025-12-18"}	2025-12-23 14:08:19	2025-12-23 13:38:59	2025-12-23 14:08:19
6bf4be77-d1a2-4fdd-96d4-4293853d6c6d	App\\Notifications\\TaskAwaitingReview	App\\Models\\User	2	{"type":"task_awaiting_review","task_id":17,"title":"Fix the frontend bug","employee_id":1,"due_date":"2025-12-28"}	2025-12-29 02:46:55	2025-12-29 02:46:10	2025-12-29 02:46:55
\.


--
-- Data for Name: password_reset_tokens; Type: TABLE DATA; Schema: public; Owner: task_user
--

COPY public.password_reset_tokens (email, token, created_at) FROM stdin;
\.


--
-- Data for Name: sessions; Type: TABLE DATA; Schema: public; Owner: task_user
--

COPY public.sessions (id, user_id, ip_address, user_agent, payload, last_activity) FROM stdin;
WYGSI7678vyZ0ZFQk02oJRgm5uqCwteVHhdpAPCu	\N	127.0.0.1	Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36	YTo0OntzOjY6Il90b2tlbiI7czo0MDoiWEVDbGJSOFB6SnZ3aTllbXJwR3V5SVhDSTBuRjV2Zk1HbjlyQXNuSCI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czozNjoiaHR0cDovL2xvY2FsaG9zdDo4MDAwL2FkbWluL21hbmFnZXJzIjt9czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9sb2dpbiI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=	1768197981
hQBof9rqHAc68skp6HqGHxYMiRskOcSOUXKpHxV4	\N	127.0.0.1	Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36	YTozOntzOjY6Il90b2tlbiI7czo0MDoiVmVLNlF6ZnlWSHVtcDdtTGQ1TXdVelo4Ulo5c3dKcWNFNnFwYnMxMSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9sb2dpbiI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=	1768233300
YJSmajI2NvkPmjCLoM2xnUWztKGAlZg50YuY9MoC	9	127.0.0.1	Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36	YTo0OntzOjY6Il90b2tlbiI7czo0MDoiczk1VmxSbzd4bzg3UEJvb1VtM1libUU1U0d1YXRkeUd1TEZ5cUk5RyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzk6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9hZG1pbi9tYW5hZ2Vycz9xPSI7czo1OiJyb3V0ZSI7czoyMDoiYWRtaW4ubWFuYWdlcnMuaW5kZXgiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTo5O30=	1766991651
VBN7HSc4lRldTkNqMG8n7lORW0CIxyGjY1DKNDoa	9	127.0.0.1	Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36	YTo0OntzOjY6Il90b2tlbiI7czo0MDoiaWxQNDZqczZhbVJuRVVKYTZ3cGxxUnlqMlJONFhpQmZjam5xV2F2byI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzY6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9hZG1pbi9tYW5hZ2VycyI7czo1OiJyb3V0ZSI7czoyMDoiYWRtaW4ubWFuYWdlcnMuaW5kZXgiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTo5O30=	1768148271
fJE49OwvNrBm8Tbueh1HPApcqJdJiBvyrpY1HuJ8	9	127.0.0.1	Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36	YTo0OntzOjY6Il90b2tlbiI7czo0MDoiYVhOTnN6Z3ZrVmFMaGZkWjVUeVFHbzhPb0VvUlYzbHVIUE1MSGFCWSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzY6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9hZG1pbi9tYW5hZ2VycyI7czo1OiJyb3V0ZSI7czoyMDoiYWRtaW4ubWFuYWdlcnMuaW5kZXgiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTo5O30=	1767827728
TmdVDoNH7RZ2XvhyXyKxzYTke8RRohH6oosIeEDk	1	127.0.0.1	Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36	YTo0OntzOjY6Il90b2tlbiI7czo0MDoiYTJEVDVvRURuRGFibHk5WmwyVGtEVHNxS1RiQnJiWVY4ellQaW5FQSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDA6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9lbXBsb3llZS9kYXNoYm9hcmQiO3M6NToicm91dGUiO3M6MTg6ImVtcGxveWVlLmRhc2hib2FyZCI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==	1767068224
j8Izr1OqDiUoOH4RyUglqyzGgGd048AdpHYXPXxU	1	127.0.0.1	Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36	YTo0OntzOjY6Il90b2tlbiI7czo0MDoiT29GbWxNUnFmV3dFbE1xOURSMWtBOVBrVm1TeW5EUG1WQVpNdk5WMSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDA6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9lbXBsb3llZS9kYXNoYm9hcmQiO3M6NToicm91dGUiO3M6MTg6ImVtcGxveWVlLmRhc2hib2FyZCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==	1774528134
\.


--
-- Data for Name: task_activities; Type: TABLE DATA; Schema: public; Owner: task_user
--

COPY public.task_activities (id, task_id, actor_id, action, meta, created_at, updated_at) FROM stdin;
37	16	2	manager_created	{"assigned_to":"1","status":"pending","due_date":"2026-01-06"}	2025-12-29 01:05:55	2025-12-29 01:05:55
38	17	2	manager_created	{"assigned_to":"1","status":"pending","due_date":"2025-12-28"}	2025-12-29 01:07:26	2025-12-29 01:07:26
39	18	2	manager_created	{"assigned_to":"16","status":"pending","due_date":"2026-01-02"}	2025-12-29 01:08:35	2025-12-29 01:08:35
40	19	2	manager_created	{"assigned_to":"16","status":"pending","due_date":"2025-12-31"}	2025-12-29 01:09:32	2025-12-29 01:09:32
41	20	18	manager_created	{"assigned_to":"20","status":"pending","due_date":"2025-12-28"}	2025-12-29 01:16:59	2025-12-29 01:16:59
42	21	18	manager_created	{"assigned_to":"19","status":"pending","due_date":"2025-12-31"}	2025-12-29 01:17:30	2025-12-29 01:17:30
43	17	1	updated	{"before":{"title":"Fix the frontend bug","description":"You need to fix the frontend bug. You have wait till the project is overdue.","status":"pending","due_date":"2025-12-28"},"after":{"title":"Fix the frontend bug","description":"You need to fix the frontend bug. You have wait till the project is overdue.","status":"in_progress","due_date":"2025-12-28"}}	2025-12-29 01:31:57	2025-12-29 01:31:57
44	16	1	updated	{"before":{"title":"Project Management","description":"Your work is to manage the project given to you by the head of the office. The work shall be done properly and sent for review. This description is important.","status":"pending","due_date":"2026-01-06"},"after":{"title":"Project Management","description":"Your work is to manage the project given to you by the head of the office. The work shall be done properly and sent for review. This description is important.","status":"in_progress","due_date":"2026-01-06"}}	2025-12-29 01:32:05	2025-12-29 01:32:05
45	16	1	updated	{"before":{"title":"Project Management","description":"Your work is to manage the project given to you by the head of the office. The work shall be done properly and sent for review. This description is important.","status":"in_progress","due_date":"2026-01-06"},"after":{"title":"Project Management","description":"Your work is to manage the project given to you by the head of the office. The work shall be done properly and sent for review. This description is important.","status":"pending","due_date":"2026-01-06"}}	2025-12-29 01:32:11	2025-12-29 01:32:11
46	21	19	updated	{"before":{"title":"Ice breaker","description":"Introduce Yourself.","status":"pending","due_date":"2025-12-31"},"after":{"title":"Ice breaker","description":"Introduce Yourself.","status":"in_progress","due_date":"2025-12-31"}}	2025-12-29 01:33:45	2025-12-29 01:33:45
47	18	2	status_changed	{"from":"pending","to":"awaiting_review"}	2025-12-29 02:11:49	2025-12-29 02:11:49
48	18	2	sent_back	{"from":"awaiting_review","to":"in_progress","comment":"Do it Better."}	2025-12-29 02:12:11	2025-12-29 02:12:11
49	22	2	manager_created	{"assigned_to":"16","status":"pending","due_date":"2025-12-31"}	2025-12-29 02:45:14	2025-12-29 02:45:14
50	17	1	updated	{"before":{"title":"Fix the frontend bug","description":"You need to fix the frontend bug. You have wait till the project is overdue.","status":"in_progress","due_date":"2025-12-28"},"after":{"title":"Fix the frontend bug","description":"You need to fix the frontend bug. You have wait till the project is overdue.","status":"awaiting_review","due_date":"2025-12-28"}}	2025-12-29 02:46:10	2025-12-29 02:46:10
51	17	2	approved	{"from":"awaiting_review","to":"done","comment":"bvbvvbvbbv"}	2025-12-29 02:47:33	2025-12-29 02:47:33
52	23	2	manager_created	{"assigned_to":"21","status":"in_progress","due_date":"2026-01-02"}	2026-01-11 15:02:55	2026-01-11 15:02:55
\.


--
-- Data for Name: task_reviews; Type: TABLE DATA; Schema: public; Owner: task_user
--

COPY public.task_reviews (id, task_id, manager_id, comment, decision, created_at, updated_at) FROM stdin;
3	18	2	Do it Better.	sent_back	2025-12-29 02:12:11	2025-12-29 02:12:11
4	17	2	bvbvvbvbbv	approved	2025-12-29 02:47:33	2025-12-29 02:47:33
\.


--
-- Data for Name: tasks; Type: TABLE DATA; Schema: public; Owner: task_user
--

COPY public.tasks (id, user_id, title, description, status, due_date, created_at, updated_at) FROM stdin;
19	16	Review the intern's work	Just review the Intern's work and let me know.	pending	2025-12-31	2025-12-29 01:09:32	2025-12-29 01:09:32
20	20	Ice breaker	Ice breakerIce breakerIce breakerIce breakerIce breakerIce breakerIce breakerIce breakerIce breakerIce breakerIce breaker.	pending	2025-12-28	2025-12-29 01:16:59	2025-12-29 01:16:59
16	1	Project Management	Your work is to manage the project given to you by the head of the office. The work shall be done properly and sent for review. This description is important.	pending	2026-01-06	2025-12-29 01:05:55	2025-12-29 01:32:11
21	19	Ice breaker	Introduce Yourself.	in_progress	2025-12-31	2025-12-29 01:17:30	2025-12-29 01:33:45
18	16	Icebreaker	Break the ice with your teammates. Have fun working in this company!	in_progress	2026-01-02	2025-12-29 01:08:35	2025-12-29 02:12:11
22	16	hghbnj	nvnbvjmn    kjnlkjnkjnk	pending	2025-12-31	2025-12-29 02:45:14	2025-12-29 02:45:14
17	1	Fix the frontend bug	You need to fix the frontend bug. You have wait till the project is overdue.	done	2025-12-28	2025-12-29 01:07:26	2025-12-29 02:47:33
23	21	bb	bbb	in_progress	2026-01-02	2026-01-11 15:02:55	2026-01-11 15:02:55
\.


--
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: task_user
--

COPY public.users (id, name, email, email_verified_at, password, remember_token, created_at, updated_at, role, employee_id, manager_id) FROM stdin;
2	Kumar	kumarappleseed@gmail.com	\N	$2y$12$oVXO7s7jyFsFsyeHtw6fse59vW34rZwpQUhZE9Q9mtQ0lJzt4xj.q	\N	2025-11-23 13:53:02	2025-11-23 13:53:02	manager	\N	\N
9	System Admin	admin@example.com	\N	$2y$12$AYkanxnHzC7ZUpXh4ezmiOSZjsE./ou2vaPAM0XoGPtU8hXMqOqJe	\N	2025-12-01 12:15:08	2025-12-01 12:15:08	admin	\N	\N
18	Patrick	patrickappleseed@gmail.com	\N	$2y$12$jIkQahPz48MYZV4l5ZC2veR7NRqkg0VqMkytF01mSsz.xL/581HlS	\N	2025-12-29 01:13:51	2025-12-29 01:13:51	manager	\N	\N
19	Farhan	farhanthegreat@gmail.com	\N	$2y$12$4MlCmhpEi4Tn/hJOCsZ.0eZlVICQf2uVN7j7qcjftdfYq3OX3wt1u	\N	2025-12-29 01:15:41	2025-12-29 01:15:41	employee	801	18
20	Ahmed	ahmedthegreat@gmail.com	\N	$2y$12$BfSpcGHgOP6s1QzVlw1LEeX/Wv01.NFOiKQdtsPBkMJopoVDNvfLC	\N	2025-12-29 01:16:16	2025-12-29 01:16:16	employee	802	18
21	gfgfcgfcgfc	vcxvcxvcxvc@qqq	\N	$2y$12$QqHMz6L2cvYXtzuBA25BPu1s9snEws9EvRut18BjFg7jJSMUlZYhq	\N	2025-12-29 02:49:23	2025-12-29 02:49:23	employee	222vbnnj	2
1	Alex	alexthegreat@gmail.com	\N	$2y$12$LQspvnyN/zr6wb0396Tjp.fDL25g5KvgjLg6auBhZ1jjbHgiHEZNS	\N	2025-11-23 11:35:39	2025-12-01 14:40:37	employee	701	2
16	Zamil	zamilthegreat@gmail.com	\N	$2y$12$5.8UhqcfVys8gUC1ZA.TzeFpQC1kv/vbxm/fQAwkG5/pWmMWlru/2	\N	2025-12-29 01:04:02	2025-12-29 01:04:02	employee	702	2
\.


--
-- Name: failed_jobs_id_seq; Type: SEQUENCE SET; Schema: public; Owner: task_user
--

SELECT pg_catalog.setval('public.failed_jobs_id_seq', 1, false);


--
-- Name: jobs_id_seq; Type: SEQUENCE SET; Schema: public; Owner: task_user
--

SELECT pg_catalog.setval('public.jobs_id_seq', 1, false);


--
-- Name: migrations_id_seq; Type: SEQUENCE SET; Schema: public; Owner: task_user
--

SELECT pg_catalog.setval('public.migrations_id_seq', 9, true);


--
-- Name: task_activities_id_seq; Type: SEQUENCE SET; Schema: public; Owner: task_user
--

SELECT pg_catalog.setval('public.task_activities_id_seq', 52, true);


--
-- Name: task_reviews_id_seq; Type: SEQUENCE SET; Schema: public; Owner: task_user
--

SELECT pg_catalog.setval('public.task_reviews_id_seq', 4, true);


--
-- Name: tasks_id_seq; Type: SEQUENCE SET; Schema: public; Owner: task_user
--

SELECT pg_catalog.setval('public.tasks_id_seq', 23, true);


--
-- Name: users_id_seq; Type: SEQUENCE SET; Schema: public; Owner: task_user
--

SELECT pg_catalog.setval('public.users_id_seq', 21, true);


--
-- Name: cache_locks cache_locks_pkey; Type: CONSTRAINT; Schema: public; Owner: task_user
--

ALTER TABLE ONLY public.cache_locks
    ADD CONSTRAINT cache_locks_pkey PRIMARY KEY (key);


--
-- Name: cache cache_pkey; Type: CONSTRAINT; Schema: public; Owner: task_user
--

ALTER TABLE ONLY public.cache
    ADD CONSTRAINT cache_pkey PRIMARY KEY (key);


--
-- Name: failed_jobs failed_jobs_pkey; Type: CONSTRAINT; Schema: public; Owner: task_user
--

ALTER TABLE ONLY public.failed_jobs
    ADD CONSTRAINT failed_jobs_pkey PRIMARY KEY (id);


--
-- Name: failed_jobs failed_jobs_uuid_unique; Type: CONSTRAINT; Schema: public; Owner: task_user
--

ALTER TABLE ONLY public.failed_jobs
    ADD CONSTRAINT failed_jobs_uuid_unique UNIQUE (uuid);


--
-- Name: job_batches job_batches_pkey; Type: CONSTRAINT; Schema: public; Owner: task_user
--

ALTER TABLE ONLY public.job_batches
    ADD CONSTRAINT job_batches_pkey PRIMARY KEY (id);


--
-- Name: jobs jobs_pkey; Type: CONSTRAINT; Schema: public; Owner: task_user
--

ALTER TABLE ONLY public.jobs
    ADD CONSTRAINT jobs_pkey PRIMARY KEY (id);


--
-- Name: migrations migrations_pkey; Type: CONSTRAINT; Schema: public; Owner: task_user
--

ALTER TABLE ONLY public.migrations
    ADD CONSTRAINT migrations_pkey PRIMARY KEY (id);


--
-- Name: notifications notifications_pkey; Type: CONSTRAINT; Schema: public; Owner: task_user
--

ALTER TABLE ONLY public.notifications
    ADD CONSTRAINT notifications_pkey PRIMARY KEY (id);


--
-- Name: password_reset_tokens password_reset_tokens_pkey; Type: CONSTRAINT; Schema: public; Owner: task_user
--

ALTER TABLE ONLY public.password_reset_tokens
    ADD CONSTRAINT password_reset_tokens_pkey PRIMARY KEY (email);


--
-- Name: sessions sessions_pkey; Type: CONSTRAINT; Schema: public; Owner: task_user
--

ALTER TABLE ONLY public.sessions
    ADD CONSTRAINT sessions_pkey PRIMARY KEY (id);


--
-- Name: task_activities task_activities_pkey; Type: CONSTRAINT; Schema: public; Owner: task_user
--

ALTER TABLE ONLY public.task_activities
    ADD CONSTRAINT task_activities_pkey PRIMARY KEY (id);


--
-- Name: task_reviews task_reviews_pkey; Type: CONSTRAINT; Schema: public; Owner: task_user
--

ALTER TABLE ONLY public.task_reviews
    ADD CONSTRAINT task_reviews_pkey PRIMARY KEY (id);


--
-- Name: tasks tasks_pkey; Type: CONSTRAINT; Schema: public; Owner: task_user
--

ALTER TABLE ONLY public.tasks
    ADD CONSTRAINT tasks_pkey PRIMARY KEY (id);


--
-- Name: users users_email_unique; Type: CONSTRAINT; Schema: public; Owner: task_user
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_email_unique UNIQUE (email);


--
-- Name: users users_employee_id_unique; Type: CONSTRAINT; Schema: public; Owner: task_user
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_employee_id_unique UNIQUE (employee_id);


--
-- Name: users users_pkey; Type: CONSTRAINT; Schema: public; Owner: task_user
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pkey PRIMARY KEY (id);


--
-- Name: jobs_queue_index; Type: INDEX; Schema: public; Owner: task_user
--

CREATE INDEX jobs_queue_index ON public.jobs USING btree (queue);


--
-- Name: notifications_notifiable_type_notifiable_id_index; Type: INDEX; Schema: public; Owner: task_user
--

CREATE INDEX notifications_notifiable_type_notifiable_id_index ON public.notifications USING btree (notifiable_type, notifiable_id);


--
-- Name: sessions_last_activity_index; Type: INDEX; Schema: public; Owner: task_user
--

CREATE INDEX sessions_last_activity_index ON public.sessions USING btree (last_activity);


--
-- Name: sessions_user_id_index; Type: INDEX; Schema: public; Owner: task_user
--

CREATE INDEX sessions_user_id_index ON public.sessions USING btree (user_id);


--
-- Name: task_activities task_activities_actor_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: task_user
--

ALTER TABLE ONLY public.task_activities
    ADD CONSTRAINT task_activities_actor_id_foreign FOREIGN KEY (actor_id) REFERENCES public.users(id) ON DELETE SET NULL;


--
-- Name: task_activities task_activities_task_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: task_user
--

ALTER TABLE ONLY public.task_activities
    ADD CONSTRAINT task_activities_task_id_foreign FOREIGN KEY (task_id) REFERENCES public.tasks(id) ON DELETE CASCADE;


--
-- Name: task_reviews task_reviews_manager_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: task_user
--

ALTER TABLE ONLY public.task_reviews
    ADD CONSTRAINT task_reviews_manager_id_foreign FOREIGN KEY (manager_id) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- Name: task_reviews task_reviews_task_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: task_user
--

ALTER TABLE ONLY public.task_reviews
    ADD CONSTRAINT task_reviews_task_id_foreign FOREIGN KEY (task_id) REFERENCES public.tasks(id) ON DELETE CASCADE;


--
-- Name: tasks tasks_user_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: task_user
--

ALTER TABLE ONLY public.tasks
    ADD CONSTRAINT tasks_user_id_foreign FOREIGN KEY (user_id) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- Name: users users_manager_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: task_user
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_manager_id_foreign FOREIGN KEY (manager_id) REFERENCES public.users(id);


--
-- PostgreSQL database dump complete
--

\unrestrict ukdsWfo9fJqvJhJTX5Pn0hTkDocasxamGPdto5uS1y5CjhsLexrp5KGiY8vj2tS

