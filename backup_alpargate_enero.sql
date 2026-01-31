--
-- PostgreSQL database dump
--

\restrict hcEhfPfWUuzggD95BV14dAnPZvcIbUr9hBOpmrb4VnW2LeWpzMvjkOajTBwh70H

-- Dumped from database version 18.1 (Debian 18.1-1.pgdg12+2)
-- Dumped by pg_dump version 18.1

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET transaction_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

--
-- Name: public; Type: SCHEMA; Schema: -; Owner: alpargatetech_db_user
--

-- *not* creating schema, since initdb creates it


ALTER SCHEMA public OWNER TO alpargatetech_db_user;

--
-- Name: SCHEMA public; Type: COMMENT; Schema: -; Owner: alpargatetech_db_user
--

COMMENT ON SCHEMA public IS '';


--
-- Name: order_status; Type: TYPE; Schema: public; Owner: alpargatetech_db_user
--

CREATE TYPE public.order_status AS ENUM (
    'Anotado',
    'En Cocina',
    'En Preparación',
    'Listo',
    'Entregado',
    'Cancelado'
);


ALTER TYPE public.order_status OWNER TO alpargatetech_db_user;

--
-- Name: table_status; Type: TYPE; Schema: public; Owner: alpargatetech_db_user
--

CREATE TYPE public.table_status AS ENUM (
    'Libre',
    'Ocupada'
);


ALTER TYPE public.table_status OWNER TO alpargatetech_db_user;

--
-- Name: user_role; Type: TYPE; Schema: public; Owner: alpargatetech_db_user
--

CREATE TYPE public.user_role AS ENUM (
    'admin',
    'mesero',
    'cocinero'
);


ALTER TYPE public.user_role OWNER TO alpargatetech_db_user;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: cache; Type: TABLE; Schema: public; Owner: alpargatetech_db_user
--

CREATE TABLE public.cache (
    key character varying(255) NOT NULL,
    value text NOT NULL,
    expiration integer NOT NULL
);


ALTER TABLE public.cache OWNER TO alpargatetech_db_user;

--
-- Name: cache_locks; Type: TABLE; Schema: public; Owner: alpargatetech_db_user
--

CREATE TABLE public.cache_locks (
    key character varying(255) NOT NULL,
    owner character varying(255) NOT NULL,
    expiration integer NOT NULL
);


ALTER TABLE public.cache_locks OWNER TO alpargatetech_db_user;

--
-- Name: categories; Type: TABLE; Schema: public; Owner: alpargatetech_db_user
--

CREATE TABLE public.categories (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone
);


ALTER TABLE public.categories OWNER TO alpargatetech_db_user;

--
-- Name: categories_id_seq; Type: SEQUENCE; Schema: public; Owner: alpargatetech_db_user
--

CREATE SEQUENCE public.categories_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.categories_id_seq OWNER TO alpargatetech_db_user;

--
-- Name: categories_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: alpargatetech_db_user
--

ALTER SEQUENCE public.categories_id_seq OWNED BY public.categories.id;


--
-- Name: clients; Type: TABLE; Schema: public; Owner: alpargatetech_db_user
--

CREATE TABLE public.clients (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    identification character varying(255),
    email character varying(255),
    phone character varying(255),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone
);


ALTER TABLE public.clients OWNER TO alpargatetech_db_user;

--
-- Name: clients_id_seq; Type: SEQUENCE; Schema: public; Owner: alpargatetech_db_user
--

CREATE SEQUENCE public.clients_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.clients_id_seq OWNER TO alpargatetech_db_user;

--
-- Name: clients_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: alpargatetech_db_user
--

ALTER SEQUENCE public.clients_id_seq OWNED BY public.clients.id;


--
-- Name: failed_jobs; Type: TABLE; Schema: public; Owner: alpargatetech_db_user
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


ALTER TABLE public.failed_jobs OWNER TO alpargatetech_db_user;

--
-- Name: failed_jobs_id_seq; Type: SEQUENCE; Schema: public; Owner: alpargatetech_db_user
--

CREATE SEQUENCE public.failed_jobs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.failed_jobs_id_seq OWNER TO alpargatetech_db_user;

--
-- Name: failed_jobs_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: alpargatetech_db_user
--

ALTER SEQUENCE public.failed_jobs_id_seq OWNED BY public.failed_jobs.id;


--
-- Name: fixed_assets; Type: TABLE; Schema: public; Owner: alpargatetech_db_user
--

CREATE TABLE public.fixed_assets (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    description text,
    quantity integer NOT NULL,
    status character varying(255),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone
);


ALTER TABLE public.fixed_assets OWNER TO alpargatetech_db_user;

--
-- Name: fixed_assets_id_seq; Type: SEQUENCE; Schema: public; Owner: alpargatetech_db_user
--

CREATE SEQUENCE public.fixed_assets_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.fixed_assets_id_seq OWNER TO alpargatetech_db_user;

--
-- Name: fixed_assets_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: alpargatetech_db_user
--

ALTER SEQUENCE public.fixed_assets_id_seq OWNED BY public.fixed_assets.id;


--
-- Name: ingredients; Type: TABLE; Schema: public; Owner: alpargatetech_db_user
--

CREATE TABLE public.ingredients (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    unit character varying(255) NOT NULL,
    stock_actual numeric(10,2) NOT NULL,
    stock_minimo numeric(10,2) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone
);


ALTER TABLE public.ingredients OWNER TO alpargatetech_db_user;

--
-- Name: ingredients_id_seq; Type: SEQUENCE; Schema: public; Owner: alpargatetech_db_user
--

CREATE SEQUENCE public.ingredients_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.ingredients_id_seq OWNER TO alpargatetech_db_user;

--
-- Name: ingredients_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: alpargatetech_db_user
--

ALTER SEQUENCE public.ingredients_id_seq OWNED BY public.ingredients.id;


--
-- Name: job_batches; Type: TABLE; Schema: public; Owner: alpargatetech_db_user
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


ALTER TABLE public.job_batches OWNER TO alpargatetech_db_user;

--
-- Name: jobs; Type: TABLE; Schema: public; Owner: alpargatetech_db_user
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


ALTER TABLE public.jobs OWNER TO alpargatetech_db_user;

--
-- Name: jobs_id_seq; Type: SEQUENCE; Schema: public; Owner: alpargatetech_db_user
--

CREATE SEQUENCE public.jobs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.jobs_id_seq OWNER TO alpargatetech_db_user;

--
-- Name: jobs_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: alpargatetech_db_user
--

ALTER SEQUENCE public.jobs_id_seq OWNED BY public.jobs.id;


--
-- Name: migrations; Type: TABLE; Schema: public; Owner: alpargatetech_db_user
--

CREATE TABLE public.migrations (
    id integer NOT NULL,
    migration character varying(255) NOT NULL,
    batch integer NOT NULL
);


ALTER TABLE public.migrations OWNER TO alpargatetech_db_user;

--
-- Name: migrations_id_seq; Type: SEQUENCE; Schema: public; Owner: alpargatetech_db_user
--

CREATE SEQUENCE public.migrations_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.migrations_id_seq OWNER TO alpargatetech_db_user;

--
-- Name: migrations_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: alpargatetech_db_user
--

ALTER SEQUENCE public.migrations_id_seq OWNED BY public.migrations.id;


--
-- Name: order_items; Type: TABLE; Schema: public; Owner: alpargatetech_db_user
--

CREATE TABLE public.order_items (
    id bigint NOT NULL,
    order_id bigint NOT NULL,
    product_id bigint NOT NULL,
    quantity integer NOT NULL,
    subtotal numeric(8,2) NOT NULL,
    notes character varying(255),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone
);


ALTER TABLE public.order_items OWNER TO alpargatetech_db_user;

--
-- Name: order_items_id_seq; Type: SEQUENCE; Schema: public; Owner: alpargatetech_db_user
--

CREATE SEQUENCE public.order_items_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.order_items_id_seq OWNER TO alpargatetech_db_user;

--
-- Name: order_items_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: alpargatetech_db_user
--

ALTER SEQUENCE public.order_items_id_seq OWNED BY public.order_items.id;


--
-- Name: orders; Type: TABLE; Schema: public; Owner: alpargatetech_db_user
--

CREATE TABLE public.orders (
    id bigint NOT NULL,
    table_id bigint NOT NULL,
    user_id bigint,
    client_id bigint,
    status character varying(255) DEFAULT 'Anotado'::character varying NOT NULL,
    total numeric(8,2) DEFAULT '0'::numeric NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone
);


ALTER TABLE public.orders OWNER TO alpargatetech_db_user;

--
-- Name: orders_id_seq; Type: SEQUENCE; Schema: public; Owner: alpargatetech_db_user
--

CREATE SEQUENCE public.orders_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.orders_id_seq OWNER TO alpargatetech_db_user;

--
-- Name: orders_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: alpargatetech_db_user
--

ALTER SEQUENCE public.orders_id_seq OWNED BY public.orders.id;


--
-- Name: password_reset_codes; Type: TABLE; Schema: public; Owner: alpargatetech_db_user
--

CREATE TABLE public.password_reset_codes (
    id bigint NOT NULL,
    email character varying(255) NOT NULL,
    code character varying(255) NOT NULL,
    created_at timestamp(0) without time zone
);


ALTER TABLE public.password_reset_codes OWNER TO alpargatetech_db_user;

--
-- Name: password_reset_codes_id_seq; Type: SEQUENCE; Schema: public; Owner: alpargatetech_db_user
--

CREATE SEQUENCE public.password_reset_codes_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.password_reset_codes_id_seq OWNER TO alpargatetech_db_user;

--
-- Name: password_reset_codes_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: alpargatetech_db_user
--

ALTER SEQUENCE public.password_reset_codes_id_seq OWNED BY public.password_reset_codes.id;


--
-- Name: password_reset_tokens; Type: TABLE; Schema: public; Owner: alpargatetech_db_user
--

CREATE TABLE public.password_reset_tokens (
    email character varying(255) NOT NULL,
    token character varying(255) NOT NULL,
    created_at timestamp(0) without time zone
);


ALTER TABLE public.password_reset_tokens OWNER TO alpargatetech_db_user;

--
-- Name: payments; Type: TABLE; Schema: public; Owner: alpargatetech_db_user
--

CREATE TABLE public.payments (
    id bigint NOT NULL,
    order_id bigint NOT NULL,
    amount numeric(8,2) NOT NULL,
    payment_method character varying(255) NOT NULL,
    paid_at timestamp(0) without time zone,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone
);


ALTER TABLE public.payments OWNER TO alpargatetech_db_user;

--
-- Name: payments_id_seq; Type: SEQUENCE; Schema: public; Owner: alpargatetech_db_user
--

CREATE SEQUENCE public.payments_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.payments_id_seq OWNER TO alpargatetech_db_user;

--
-- Name: payments_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: alpargatetech_db_user
--

ALTER SEQUENCE public.payments_id_seq OWNED BY public.payments.id;


--
-- Name: products; Type: TABLE; Schema: public; Owner: alpargatetech_db_user
--

CREATE TABLE public.products (
    id bigint NOT NULL,
    category_id bigint NOT NULL,
    name character varying(255) NOT NULL,
    price numeric(8,2) NOT NULL,
    description text,
    stock integer DEFAULT 0,
    is_active boolean DEFAULT true NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone
);


ALTER TABLE public.products OWNER TO alpargatetech_db_user;

--
-- Name: products_id_seq; Type: SEQUENCE; Schema: public; Owner: alpargatetech_db_user
--

CREATE SEQUENCE public.products_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.products_id_seq OWNER TO alpargatetech_db_user;

--
-- Name: products_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: alpargatetech_db_user
--

ALTER SEQUENCE public.products_id_seq OWNED BY public.products.id;


--
-- Name: recipes; Type: TABLE; Schema: public; Owner: alpargatetech_db_user
--

CREATE TABLE public.recipes (
    id bigint NOT NULL,
    product_id bigint NOT NULL,
    ingredient_id bigint NOT NULL,
    quantity_required numeric(10,2) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone
);


ALTER TABLE public.recipes OWNER TO alpargatetech_db_user;

--
-- Name: recipes_id_seq; Type: SEQUENCE; Schema: public; Owner: alpargatetech_db_user
--

CREATE SEQUENCE public.recipes_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.recipes_id_seq OWNER TO alpargatetech_db_user;

--
-- Name: recipes_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: alpargatetech_db_user
--

ALTER SEQUENCE public.recipes_id_seq OWNED BY public.recipes.id;


--
-- Name: sessions; Type: TABLE; Schema: public; Owner: alpargatetech_db_user
--

CREATE TABLE public.sessions (
    id character varying(255) NOT NULL,
    user_id bigint,
    ip_address character varying(45),
    user_agent text,
    payload text NOT NULL,
    last_activity integer NOT NULL
);


ALTER TABLE public.sessions OWNER TO alpargatetech_db_user;

--
-- Name: tables; Type: TABLE; Schema: public; Owner: alpargatetech_db_user
--

CREATE TABLE public.tables (
    id bigint NOT NULL,
    number integer NOT NULL,
    capacity integer NOT NULL,
    status character varying(255) DEFAULT 'Libre'::character varying NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone
);


ALTER TABLE public.tables OWNER TO alpargatetech_db_user;

--
-- Name: tables_id_seq; Type: SEQUENCE; Schema: public; Owner: alpargatetech_db_user
--

CREATE SEQUENCE public.tables_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.tables_id_seq OWNER TO alpargatetech_db_user;

--
-- Name: tables_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: alpargatetech_db_user
--

ALTER SEQUENCE public.tables_id_seq OWNED BY public.tables.id;


--
-- Name: users; Type: TABLE; Schema: public; Owner: alpargatetech_db_user
--

CREATE TABLE public.users (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    email character varying(255) NOT NULL,
    email_verified_at timestamp(0) without time zone,
    password character varying(255) NOT NULL,
    role character varying(255) DEFAULT 'mesero'::character varying NOT NULL,
    remember_token character varying(100),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone,
    two_factor_code character varying(255),
    two_factor_expires_at timestamp(0) without time zone
);


ALTER TABLE public.users OWNER TO alpargatetech_db_user;

--
-- Name: users_id_seq; Type: SEQUENCE; Schema: public; Owner: alpargatetech_db_user
--

CREATE SEQUENCE public.users_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.users_id_seq OWNER TO alpargatetech_db_user;

--
-- Name: users_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: alpargatetech_db_user
--

ALTER SEQUENCE public.users_id_seq OWNED BY public.users.id;


--
-- Name: categories id; Type: DEFAULT; Schema: public; Owner: alpargatetech_db_user
--

ALTER TABLE ONLY public.categories ALTER COLUMN id SET DEFAULT nextval('public.categories_id_seq'::regclass);


--
-- Name: clients id; Type: DEFAULT; Schema: public; Owner: alpargatetech_db_user
--

ALTER TABLE ONLY public.clients ALTER COLUMN id SET DEFAULT nextval('public.clients_id_seq'::regclass);


--
-- Name: failed_jobs id; Type: DEFAULT; Schema: public; Owner: alpargatetech_db_user
--

ALTER TABLE ONLY public.failed_jobs ALTER COLUMN id SET DEFAULT nextval('public.failed_jobs_id_seq'::regclass);


--
-- Name: fixed_assets id; Type: DEFAULT; Schema: public; Owner: alpargatetech_db_user
--

ALTER TABLE ONLY public.fixed_assets ALTER COLUMN id SET DEFAULT nextval('public.fixed_assets_id_seq'::regclass);


--
-- Name: ingredients id; Type: DEFAULT; Schema: public; Owner: alpargatetech_db_user
--

ALTER TABLE ONLY public.ingredients ALTER COLUMN id SET DEFAULT nextval('public.ingredients_id_seq'::regclass);


--
-- Name: jobs id; Type: DEFAULT; Schema: public; Owner: alpargatetech_db_user
--

ALTER TABLE ONLY public.jobs ALTER COLUMN id SET DEFAULT nextval('public.jobs_id_seq'::regclass);


--
-- Name: migrations id; Type: DEFAULT; Schema: public; Owner: alpargatetech_db_user
--

ALTER TABLE ONLY public.migrations ALTER COLUMN id SET DEFAULT nextval('public.migrations_id_seq'::regclass);


--
-- Name: order_items id; Type: DEFAULT; Schema: public; Owner: alpargatetech_db_user
--

ALTER TABLE ONLY public.order_items ALTER COLUMN id SET DEFAULT nextval('public.order_items_id_seq'::regclass);


--
-- Name: orders id; Type: DEFAULT; Schema: public; Owner: alpargatetech_db_user
--

ALTER TABLE ONLY public.orders ALTER COLUMN id SET DEFAULT nextval('public.orders_id_seq'::regclass);


--
-- Name: password_reset_codes id; Type: DEFAULT; Schema: public; Owner: alpargatetech_db_user
--

ALTER TABLE ONLY public.password_reset_codes ALTER COLUMN id SET DEFAULT nextval('public.password_reset_codes_id_seq'::regclass);


--
-- Name: payments id; Type: DEFAULT; Schema: public; Owner: alpargatetech_db_user
--

ALTER TABLE ONLY public.payments ALTER COLUMN id SET DEFAULT nextval('public.payments_id_seq'::regclass);


--
-- Name: products id; Type: DEFAULT; Schema: public; Owner: alpargatetech_db_user
--

ALTER TABLE ONLY public.products ALTER COLUMN id SET DEFAULT nextval('public.products_id_seq'::regclass);


--
-- Name: recipes id; Type: DEFAULT; Schema: public; Owner: alpargatetech_db_user
--

ALTER TABLE ONLY public.recipes ALTER COLUMN id SET DEFAULT nextval('public.recipes_id_seq'::regclass);


--
-- Name: tables id; Type: DEFAULT; Schema: public; Owner: alpargatetech_db_user
--

ALTER TABLE ONLY public.tables ALTER COLUMN id SET DEFAULT nextval('public.tables_id_seq'::regclass);


--
-- Name: users id; Type: DEFAULT; Schema: public; Owner: alpargatetech_db_user
--

ALTER TABLE ONLY public.users ALTER COLUMN id SET DEFAULT nextval('public.users_id_seq'::regclass);


--
-- Data for Name: cache; Type: TABLE DATA; Schema: public; Owner: alpargatetech_db_user
--

COPY public.cache (key, value, expiration) FROM stdin;
\.


--
-- Data for Name: cache_locks; Type: TABLE DATA; Schema: public; Owner: alpargatetech_db_user
--

COPY public.cache_locks (key, owner, expiration) FROM stdin;
\.


--
-- Data for Name: categories; Type: TABLE DATA; Schema: public; Owner: alpargatetech_db_user
--

COPY public.categories (id, name, created_at, updated_at, deleted_at) FROM stdin;
1	Bebidas	\N	\N	\N
2	Platos Fuertes	\N	\N	\N
3	Postres	\N	\N	\N
\.


--
-- Data for Name: clients; Type: TABLE DATA; Schema: public; Owner: alpargatetech_db_user
--

COPY public.clients (id, name, identification, email, phone, created_at, updated_at, deleted_at) FROM stdin;
1	Pedro Gómez	0102030405	pedro@gmail.com	0999999999	\N	\N	\N
2	María Torres	0607080910	maria@gmail.com	0988888888	\N	\N	\N
\.


--
-- Data for Name: failed_jobs; Type: TABLE DATA; Schema: public; Owner: alpargatetech_db_user
--

COPY public.failed_jobs (id, uuid, connection, queue, payload, exception, failed_at) FROM stdin;
\.


--
-- Data for Name: fixed_assets; Type: TABLE DATA; Schema: public; Owner: alpargatetech_db_user
--

COPY public.fixed_assets (id, name, description, quantity, status, created_at, updated_at, deleted_at) FROM stdin;
1	Mesa Madera	Mesa para 4 personas	5	Buen estado	\N	\N	\N
2	Sillas	Sillas plásticas	20	Buen estado	\N	\N	\N
3	Horno	Horno industrial	1	Mantenimiento	\N	\N	\N
\.


--
-- Data for Name: ingredients; Type: TABLE DATA; Schema: public; Owner: alpargatetech_db_user
--

COPY public.ingredients (id, name, unit, stock_actual, stock_minimo, created_at, updated_at, deleted_at) FROM stdin;
1	Pan	unidad	50.00	10.00	\N	\N	\N
2	Carne	gr	5000.00	1000.00	\N	\N	\N
3	Queso	gr	3000.00	500.00	\N	\N	\N
4	Harina	gr	10000.00	2000.00	\N	\N	\N
5	Chocolate	gr	2000.00	300.00	\N	\N	\N
\.


--
-- Data for Name: job_batches; Type: TABLE DATA; Schema: public; Owner: alpargatetech_db_user
--

COPY public.job_batches (id, name, total_jobs, pending_jobs, failed_jobs, failed_job_ids, options, cancelled_at, created_at, finished_at) FROM stdin;
\.


--
-- Data for Name: jobs; Type: TABLE DATA; Schema: public; Owner: alpargatetech_db_user
--

COPY public.jobs (id, queue, payload, attempts, reserved_at, available_at, created_at) FROM stdin;
\.


--
-- Data for Name: migrations; Type: TABLE DATA; Schema: public; Owner: alpargatetech_db_user
--

COPY public.migrations (id, migration, batch) FROM stdin;
1	0001_01_01_000000_create_users_table	1
2	0001_01_01_000001_create_cache_table	1
3	0001_01_01_000002_create_jobs_table	1
4	2026_01_17_051632_create_password_reset_codes_table	1
5	2026_01_19_001904_add_2fa_to_users_table	1
6	2026_01_20_034328_recreate_missing_tables	1
\.


--
-- Data for Name: order_items; Type: TABLE DATA; Schema: public; Owner: alpargatetech_db_user
--

COPY public.order_items (id, order_id, product_id, quantity, subtotal, notes, created_at, updated_at, deleted_at) FROM stdin;
4	3	3	1	5.50	Sin cebolla	\N	\N	\N
5	3	1	1	1.50	\N	\N	\N	\N
6	4	4	1	6.00	Extra queso	\N	\N	\N
7	9	1	4	6.00	\N	\N	\N	\N
8	9	2	4	8.00	\N	\N	\N	\N
9	9	4	3	18.00	\N	\N	\N	\N
10	9	5	2	6.00	\N	\N	\N	\N
11	10	2	2	4.00	\N	\N	\N	\N
12	13	1	0	0.00	\N	\N	\N	\N
13	13	1	2	3.00	\N	\N	\N	\N
14	13	2	5	10.00	\N	\N	\N	\N
15	13	4	2	12.00	\N	\N	\N	\N
16	13	3	3	16.50	\N	\N	\N	\N
17	13	5	3	9.00	\N	\N	\N	\N
18	14	2	2	4.00	\N	\N	\N	\N
19	14	4	0	0.00	\N	\N	\N	\N
20	14	4	2	12.00	\N	\N	\N	\N
21	14	3	2	11.00	\N	\N	\N	\N
22	15	2	5	10.00	\N	\N	\N	\N
23	16	4	2	12.00	\N	\N	\N	\N
24	17	2	9	18.00	\N	\N	\N	\N
25	17	1	2	3.00	\N	\N	\N	\N
26	18	2	50	100.00	\N	\N	\N	\N
27	17	2	3	6.00	\N	\N	\N	\N
28	17	2	2	4.00	\N	\N	\N	\N
29	19	2	4	8.00	\N	\N	\N	\N
30	20	2	10	20.00	\N	\N	\N	\N
31	21	2	4	8.00	\N	\N	\N	\N
32	22	2	3	6.00	\N	\N	\N	\N
33	23	2	4	8.00	\N	\N	\N	\N
34	25	4	4	24.00	\N	\N	\N	\N
35	26	2	3	6.00	\N	\N	\N	\N
36	27	4	4	24.00	\N	\N	\N	\N
37	28	2	3	6.00	\N	\N	\N	\N
38	29	2	4	8.00	\N	\N	\N	\N
39	32	2	3	6.00	\N	\N	\N	\N
40	32	2	8	16.00	\N	\N	\N	\N
41	33	2	8	16.00	\N	\N	\N	\N
42	35	2	6	12.00	\N	\N	\N	\N
43	37	1	3	4.50	\N	\N	\N	\N
44	37	4	3	18.00	\N	\N	\N	\N
45	37	3	1	5.50	\N	\N	\N	\N
46	37	4	4	24.00	\N	\N	\N	\N
47	37	1	0	0.00	\N	\N	\N	\N
48	39	2	1	2.00	\N	\N	\N	\N
49	39	4	1	6.00	\N	\N	\N	\N
50	40	2	1	2.00	\N	\N	\N	\N
51	40	1	3	4.50	\N	\N	\N	\N
52	41	2	1	2.00	\N	\N	\N	\N
53	42	2	1	2.00	\N	\N	\N	\N
54	42	2	1	2.00	\N	\N	\N	\N
55	43	1	1	1.50	\N	\N	\N	\N
56	43	1	1	1.50	\N	\N	\N	\N
57	43	3	1	5.50	\N	\N	\N	\N
58	45	1	1	1.50	\N	\N	\N	\N
59	45	2	1	2.00	\N	\N	\N	\N
60	45	2	1	2.00	\N	\N	\N	\N
61	45	4	1	6.00	\N	\N	\N	\N
62	46	2	1	2.00	\N	\N	\N	\N
63	46	1	1	1.50	\N	\N	\N	\N
64	48	4	1	6.00	\N	\N	\N	\N
65	49	4	1	6.00	\N	\N	\N	\N
66	53	2	4	8.00	\N	\N	\N	\N
67	54	2	3	6.00	\N	\N	\N	\N
68	55	2	1	2.00	\N	\N	\N	\N
69	56	4	2	12.00	\N	\N	\N	\N
70	56	4	1	6.00	\N	\N	\N	\N
71	56	4	1	6.00	\N	\N	\N	\N
72	57	2	4	8.00	\N	\N	\N	\N
\.


--
-- Data for Name: orders; Type: TABLE DATA; Schema: public; Owner: alpargatetech_db_user
--

COPY public.orders (id, table_id, user_id, client_id, status, total, created_at, updated_at, deleted_at) FROM stdin;
39	1	2	\N	Entregado	8.00	2026-01-06 07:58:41	2026-01-06 07:58:41	\N
5	1	2	\N	Anotado	0.00	2026-01-02 19:19:56	2026-01-02 19:19:56	\N
6	5	2	\N	Anotado	0.00	2026-01-02 19:23:20	2026-01-02 19:23:20	\N
7	3	2	\N	Listo	0.00	2026-01-02 19:25:17	2026-01-02 19:25:17	\N
8	6	1	\N	Listo	0.00	2026-01-02 20:04:06	2026-01-02 20:04:06	\N
41	1	2	\N	Entregado	2.00	2026-01-06 09:33:41	2026-01-06 09:33:41	\N
9	7	1	\N	Listo	38.00	2026-01-02 20:10:01	2026-01-02 20:10:01	\N
11	4	1	\N	Anotado	0.00	2026-01-02 20:27:07	2026-01-02 20:27:07	\N
12	4	1	\N	Entregado	0.00	2026-01-02 20:29:11	2026-01-02 20:29:11	\N
10	1	1	\N	Listo	4.00	2026-01-02 20:14:42	2026-01-02 20:14:42	\N
4	1	2	2	Entregado	6.00	2026-01-02 23:55:21	2026-01-02 23:55:21	\N
25	7	1	\N	Entregado	24.00	2026-01-02 23:03:31	2026-01-02 23:03:31	\N
26	6	1	\N	Entregado	6.00	2026-01-02 23:06:11	2026-01-02 23:06:11	\N
23	3	1	\N	Entregado	8.00	2026-01-02 22:56:55	2026-01-02 22:56:55	\N
24	5	1	\N	Entregado	0.00	2026-01-02 23:03:21	2026-01-02 23:03:21	\N
22	4	1	\N	Entregado	6.00	2026-01-02 22:50:46	2026-01-02 22:50:46	\N
27	1	1	\N	Entregado	24.00	2026-01-02 23:14:29	2026-01-02 23:14:29	\N
14	3	2	\N	Entregado	27.00	2026-01-02 20:44:22	2026-01-02 20:44:22	\N
13	1	2	\N	Entregado	50.50	2026-01-02 20:43:33	2026-01-02 20:43:33	\N
16	4	1	\N	Listo	12.00	2026-01-02 20:49:09	2026-01-02 20:49:09	\N
15	1	1	\N	Entregado	10.00	2026-01-02 20:47:25	2026-01-02 20:47:25	\N
30	3	1	\N	Anotado	0.00	2026-01-02 23:24:42	2026-01-02 23:24:42	\N
31	3	1	\N	Anotado	0.00	2026-01-02 23:24:50	2026-01-02 23:24:50	\N
34	5	1	\N	Anotado	0.00	2026-01-02 23:41:46	2026-01-02 23:41:46	\N
45	3	1	\N	Entregado	11.50	2026-01-10 19:55:02	2026-01-10 19:55:02	\N
44	5	2	\N	Entregado	0.00	2026-01-06 09:34:47	2026-01-06 09:34:47	\N
43	4	2	\N	Entregado	8.50	2026-01-06 09:34:34	2026-01-06 09:34:34	\N
42	1	2	\N	Entregado	4.00	2026-01-06 09:34:21	2026-01-06 09:34:21	\N
19	7	1	\N	Entregado	8.00	2026-01-02 22:36:39	2026-01-02 22:36:39	\N
18	6	2	\N	Entregado	100.00	2026-01-02 22:31:54	2026-01-02 22:31:54	\N
17	3	2	\N	Entregado	31.00	2026-01-02 22:16:31	2026-01-02 22:16:31	\N
20	5	1	\N	Entregado	20.00	2026-01-02 22:36:55	2026-01-02 22:36:55	\N
3	4	2	1	Entregado	9.00	2026-01-02 23:55:21	2026-01-02 23:55:21	\N
21	1	1	\N	Entregado	8.00	2026-01-02 22:49:43	2026-01-02 22:49:43	\N
28	4	1	\N	Entregado	6.00	2026-01-02 23:21:33	2026-01-02 23:21:33	\N
35	5	1	\N	Entregado	12.00	2026-01-02 23:41:47	2026-01-02 23:41:47	\N
32	3	1	\N	Entregado	22.00	2026-01-02 23:24:56	2026-01-02 23:24:56	\N
29	6	1	\N	Entregado	8.00	2026-01-02 23:23:27	2026-01-02 23:23:27	\N
36	6	1	\N	Entregado	0.00	2026-01-06 07:36:29	2026-01-06 07:36:29	\N
46	1	2	\N	Entregado	3.50	2026-01-13 07:29:25	2026-01-13 07:29:25	\N
47	4	2	\N	Entregado	0.00	2026-01-13 07:30:37	2026-01-13 07:30:37	\N
37	5	1	\N	Entregado	52.00	2026-01-06 07:36:40	2026-01-06 07:36:40	\N
33	7	1	\N	Entregado	16.00	2026-01-02 23:33:30	2026-01-02 23:33:30	\N
38	3	1	\N	Entregado	0.00	2026-01-06 07:46:12	2026-01-06 07:46:12	\N
40	4	2	\N	Entregado	6.50	2026-01-06 08:57:43	2026-01-06 08:57:43	\N
56	7	7	\N	En Cocina	24.00	2026-01-20 13:32:46	2026-01-20 13:52:03	\N
53	5	7	\N	Entregado	8.00	2026-01-20 13:12:40	2026-01-20 13:59:09	\N
49	4	1	\N	Entregado	6.00	2026-01-20 04:17:20	2026-01-20 04:23:33	\N
48	1	1	\N	Entregado	6.00	2026-01-13 07:32:51	2026-01-20 04:28:40	\N
50	1	7	\N	Entregado	0.00	2026-01-20 12:58:20	2026-01-20 12:58:43	\N
57	5	7	\N	Listo	8.00	2026-01-20 13:59:22	2026-01-20 14:03:19	\N
54	3	7	\N	En Preparación	6.00	2026-01-20 13:19:50	2026-01-20 14:05:01	\N
55	6	7	\N	En Cocina	2.00	2026-01-20 13:31:11	2026-01-20 13:31:39	\N
51	1	7	\N	Listo	0.00	2026-01-20 12:59:20	2026-01-20 13:51:08	\N
52	4	7	\N	Listo	0.00	2026-01-20 13:01:00	2026-01-20 13:01:18	\N
\.


--
-- Data for Name: password_reset_codes; Type: TABLE DATA; Schema: public; Owner: alpargatetech_db_user
--

COPY public.password_reset_codes (id, email, code, created_at) FROM stdin;
\.


--
-- Data for Name: password_reset_tokens; Type: TABLE DATA; Schema: public; Owner: alpargatetech_db_user
--

COPY public.password_reset_tokens (email, token, created_at) FROM stdin;
\.


--
-- Data for Name: payments; Type: TABLE DATA; Schema: public; Owner: alpargatetech_db_user
--

COPY public.payments (id, order_id, amount, payment_method, paid_at, created_at, updated_at, deleted_at) FROM stdin;
2	12	0.00	Efectivo	2026-01-02 20:29:43	\N	\N	\N
4	4	6.00	Transferencia	2026-01-02 20:30:42	\N	\N	\N
5	14	27.00	Tarjeta	2026-01-02 20:46:59	\N	\N	\N
6	13	50.50	Tarjeta	2026-01-02 20:47:09	\N	\N	\N
8	15	10.00	Tarjeta	2026-01-02 20:49:33	\N	\N	\N
10	19	8.00	Efectivo	2026-01-02 22:50:14	\N	\N	\N
11	18	100.00	Efectivo	2026-01-02 22:50:17	\N	\N	\N
12	17	31.00	Efectivo	2026-01-02 22:50:19	\N	\N	\N
13	20	20.00	Efectivo	2026-01-02 22:50:22	\N	\N	\N
14	3	9.00	Efectivo	2026-01-02 22:50:24	\N	\N	\N
15	21	8.00	Efectivo	2026-01-02 22:50:27	\N	\N	\N
16	25	24.00	Efectivo	2026-01-02 23:14:52	\N	\N	\N
17	26	6.00	Efectivo	2026-01-02 23:14:54	\N	\N	\N
18	23	8.00	Efectivo	2026-01-02 23:14:57	\N	\N	\N
19	24	0.00	Efectivo	2026-01-02 23:15:02	\N	\N	\N
20	22	6.00	Efectivo	2026-01-02 23:15:05	\N	\N	\N
21	27	24.00	Efectivo	2026-01-02 23:15:07	\N	\N	\N
22	28	6.00	Efectivo	2026-01-06 07:35:27	\N	\N	\N
23	35	12.00	Efectivo	2026-01-06 07:35:31	\N	\N	\N
24	32	22.00	Efectivo	2026-01-06 07:35:34	\N	\N	\N
25	29	8.00	Efectivo	2026-01-06 07:35:47	\N	\N	\N
26	36	0.00	Tarjeta	2026-01-06 07:37:17	\N	\N	\N
27	37	52.00	Efectivo	2026-01-06 08:57:40	\N	\N	\N
28	33	16.00	Efectivo	2026-01-06 09:31:09	\N	\N	\N
29	38	0.00	Efectivo	2026-01-06 09:31:13	\N	\N	\N
30	40	6.50	Efectivo	2026-01-06 09:31:16	\N	\N	\N
31	39	8.00	Efectivo	2026-01-06 09:31:20	\N	\N	\N
32	41	2.00	Efectivo	2026-01-06 09:33:48	\N	\N	\N
33	45	11.50	Efectivo	2026-01-13 07:25:16	\N	\N	\N
34	44	0.00	Efectivo	2026-01-13 07:25:19	\N	\N	\N
35	43	8.50	Efectivo	2026-01-13 07:25:22	\N	\N	\N
36	42	4.00	Efectivo	2026-01-13 07:25:43	\N	\N	\N
37	46	3.50	Efectivo	2026-01-13 07:31:47	\N	\N	\N
38	47	0.00	Tarjeta	2026-01-13 07:34:43	\N	\N	\N
39	49	6.00	Efectivo	\N	2026-01-20 04:23:33	2026-01-20 04:23:33	\N
40	48	6.00	Efectivo	\N	2026-01-20 04:28:39	2026-01-20 04:28:39	\N
41	50	0.00	Efectivo	\N	2026-01-20 12:58:42	2026-01-20 12:58:42	\N
42	53	8.00	Efectivo	\N	2026-01-20 13:59:09	2026-01-20 13:59:09	\N
\.


--
-- Data for Name: products; Type: TABLE DATA; Schema: public; Owner: alpargatetech_db_user
--

COPY public.products (id, category_id, name, price, description, stock, is_active, created_at, updated_at, deleted_at) FROM stdin;
1	1	Coca Cola	1.50	Bebida gaseosa 350ml	0	t	\N	\N	\N
2	1	Jugo Natural	2.00	Jugo de naranja	0	t	\N	\N	\N
3	2	Hamburguesa	5.50	Hamburguesa clásica	0	t	\N	\N	\N
4	2	Pizza Personal	6.00	Pizza de queso	0	t	\N	\N	\N
5	3	Pastel de Chocolate	3.00	Porción individual	0	t	\N	\N	\N
\.


--
-- Data for Name: recipes; Type: TABLE DATA; Schema: public; Owner: alpargatetech_db_user
--

COPY public.recipes (id, product_id, ingredient_id, quantity_required, created_at, updated_at, deleted_at) FROM stdin;
1	3	1	1.00	\N	\N	\N
2	3	2	150.00	\N	\N	\N
3	3	3	50.00	\N	\N	\N
4	4	4	200.00	\N	\N	\N
5	4	3	100.00	\N	\N	\N
6	5	4	100.00	\N	\N	\N
7	5	5	50.00	\N	\N	\N
\.


--
-- Data for Name: sessions; Type: TABLE DATA; Schema: public; Owner: alpargatetech_db_user
--

COPY public.sessions (id, user_id, ip_address, user_agent, payload, last_activity) FROM stdin;
\.


--
-- Data for Name: tables; Type: TABLE DATA; Schema: public; Owner: alpargatetech_db_user
--

COPY public.tables (id, number, capacity, status, created_at, updated_at, deleted_at) FROM stdin;
1	1	4	Ocupada	\N	\N	\N
4	2	2	Ocupada	\N	\N	\N
3	4	4	Ocupada	\N	\N	\N
6	7	4	Ocupada	\N	\N	\N
7	8	4	Ocupada	\N	\N	\N
5	3	6	Ocupada	\N	\N	\N
\.


--
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: alpargatetech_db_user
--

COPY public.users (id, name, email, email_verified_at, password, role, remember_token, created_at, updated_at, deleted_at, two_factor_code, two_factor_expires_at) FROM stdin;
2	Mesero Juan	juan@alfonso.com	\N	$2y$12$JtB/nrsWaUlH3xGXTxasweHKPaei7hC.BvcebU/T1jCCSNyTGujAe	mesero	\N	2026-01-02 23:04:41	2026-01-02 23:04:41	\N	\N	\N
3	Admin Principal	admin@resto.com	\N	$2y$10$hashadmin	admin	\N	2026-01-02 23:52:18	2026-01-02 23:52:18	\N	\N	\N
4	Juan Mesero	mesero@resto.com	\N	$2y$10$hashmesero	mesero	\N	2026-01-02 23:52:18	2026-01-02 23:52:18	\N	\N	\N
5	Carlos Cocina	cocinero@resto.com	\N	$2y$10$hashcocina	cocinero	\N	2026-01-02 23:52:18	2026-01-02 23:52:18	\N	\N	\N
6	Cocinero Daro	LocoDaro@alfonso.com	\N	$2y$12$UVd47M4WnYCp44toHSjT4el3.xfFHAcyny/H6vgXFqA1o5rVbwUY6	cocinero	\N	2026-01-03 03:14:00	2026-01-03 03:14:00	\N	\N	\N
1	Administrador de Prueba	admin@alfonso.com	\N	$2y$12$iisdOqxKk/6.AkWd7cyAdugrRqW9ZGGDVH0MYZmqTLeLBdAwCkQ.K	admin	\N	2026-01-02 21:54:29	2026-01-20 12:52:17	\N	\N	\N
7	Tebo Carrion	dsigual6@gmail.com	\N	$2y$12$/kdWw3Hn1iOC.FVojugDoux.eJInMceA67HPi0GTESvpMUQk8ydHu	admin	\N	2026-01-20 12:54:55	2026-01-20 13:50:26	\N	\N	\N
\.


--
-- Name: categories_id_seq; Type: SEQUENCE SET; Schema: public; Owner: alpargatetech_db_user
--

SELECT pg_catalog.setval('public.categories_id_seq', 3, true);


--
-- Name: clients_id_seq; Type: SEQUENCE SET; Schema: public; Owner: alpargatetech_db_user
--

SELECT pg_catalog.setval('public.clients_id_seq', 2, true);


--
-- Name: failed_jobs_id_seq; Type: SEQUENCE SET; Schema: public; Owner: alpargatetech_db_user
--

SELECT pg_catalog.setval('public.failed_jobs_id_seq', 1, false);


--
-- Name: fixed_assets_id_seq; Type: SEQUENCE SET; Schema: public; Owner: alpargatetech_db_user
--

SELECT pg_catalog.setval('public.fixed_assets_id_seq', 3, true);


--
-- Name: ingredients_id_seq; Type: SEQUENCE SET; Schema: public; Owner: alpargatetech_db_user
--

SELECT pg_catalog.setval('public.ingredients_id_seq', 5, true);


--
-- Name: jobs_id_seq; Type: SEQUENCE SET; Schema: public; Owner: alpargatetech_db_user
--

SELECT pg_catalog.setval('public.jobs_id_seq', 1, false);


--
-- Name: migrations_id_seq; Type: SEQUENCE SET; Schema: public; Owner: alpargatetech_db_user
--

SELECT pg_catalog.setval('public.migrations_id_seq', 2, true);


--
-- Name: order_items_id_seq; Type: SEQUENCE SET; Schema: public; Owner: alpargatetech_db_user
--

SELECT pg_catalog.setval('public.order_items_id_seq', 72, true);


--
-- Name: orders_id_seq; Type: SEQUENCE SET; Schema: public; Owner: alpargatetech_db_user
--

SELECT pg_catalog.setval('public.orders_id_seq', 57, true);


--
-- Name: password_reset_codes_id_seq; Type: SEQUENCE SET; Schema: public; Owner: alpargatetech_db_user
--

SELECT pg_catalog.setval('public.password_reset_codes_id_seq', 1, false);


--
-- Name: payments_id_seq; Type: SEQUENCE SET; Schema: public; Owner: alpargatetech_db_user
--

SELECT pg_catalog.setval('public.payments_id_seq', 42, true);


--
-- Name: products_id_seq; Type: SEQUENCE SET; Schema: public; Owner: alpargatetech_db_user
--

SELECT pg_catalog.setval('public.products_id_seq', 5, true);


--
-- Name: recipes_id_seq; Type: SEQUENCE SET; Schema: public; Owner: alpargatetech_db_user
--

SELECT pg_catalog.setval('public.recipes_id_seq', 7, true);


--
-- Name: tables_id_seq; Type: SEQUENCE SET; Schema: public; Owner: alpargatetech_db_user
--

SELECT pg_catalog.setval('public.tables_id_seq', 7, true);


--
-- Name: users_id_seq; Type: SEQUENCE SET; Schema: public; Owner: alpargatetech_db_user
--

SELECT pg_catalog.setval('public.users_id_seq', 7, true);


--
-- Name: cache_locks cache_locks_pkey; Type: CONSTRAINT; Schema: public; Owner: alpargatetech_db_user
--

ALTER TABLE ONLY public.cache_locks
    ADD CONSTRAINT cache_locks_pkey PRIMARY KEY (key);


--
-- Name: cache cache_pkey; Type: CONSTRAINT; Schema: public; Owner: alpargatetech_db_user
--

ALTER TABLE ONLY public.cache
    ADD CONSTRAINT cache_pkey PRIMARY KEY (key);


--
-- Name: categories categories_pkey; Type: CONSTRAINT; Schema: public; Owner: alpargatetech_db_user
--

ALTER TABLE ONLY public.categories
    ADD CONSTRAINT categories_pkey PRIMARY KEY (id);


--
-- Name: clients clients_pkey; Type: CONSTRAINT; Schema: public; Owner: alpargatetech_db_user
--

ALTER TABLE ONLY public.clients
    ADD CONSTRAINT clients_pkey PRIMARY KEY (id);


--
-- Name: failed_jobs failed_jobs_pkey; Type: CONSTRAINT; Schema: public; Owner: alpargatetech_db_user
--

ALTER TABLE ONLY public.failed_jobs
    ADD CONSTRAINT failed_jobs_pkey PRIMARY KEY (id);


--
-- Name: failed_jobs failed_jobs_uuid_unique; Type: CONSTRAINT; Schema: public; Owner: alpargatetech_db_user
--

ALTER TABLE ONLY public.failed_jobs
    ADD CONSTRAINT failed_jobs_uuid_unique UNIQUE (uuid);


--
-- Name: fixed_assets fixed_assets_pkey; Type: CONSTRAINT; Schema: public; Owner: alpargatetech_db_user
--

ALTER TABLE ONLY public.fixed_assets
    ADD CONSTRAINT fixed_assets_pkey PRIMARY KEY (id);


--
-- Name: ingredients ingredients_pkey; Type: CONSTRAINT; Schema: public; Owner: alpargatetech_db_user
--

ALTER TABLE ONLY public.ingredients
    ADD CONSTRAINT ingredients_pkey PRIMARY KEY (id);


--
-- Name: job_batches job_batches_pkey; Type: CONSTRAINT; Schema: public; Owner: alpargatetech_db_user
--

ALTER TABLE ONLY public.job_batches
    ADD CONSTRAINT job_batches_pkey PRIMARY KEY (id);


--
-- Name: jobs jobs_pkey; Type: CONSTRAINT; Schema: public; Owner: alpargatetech_db_user
--

ALTER TABLE ONLY public.jobs
    ADD CONSTRAINT jobs_pkey PRIMARY KEY (id);


--
-- Name: migrations migrations_pkey; Type: CONSTRAINT; Schema: public; Owner: alpargatetech_db_user
--

ALTER TABLE ONLY public.migrations
    ADD CONSTRAINT migrations_pkey PRIMARY KEY (id);


--
-- Name: order_items order_items_pkey; Type: CONSTRAINT; Schema: public; Owner: alpargatetech_db_user
--

ALTER TABLE ONLY public.order_items
    ADD CONSTRAINT order_items_pkey PRIMARY KEY (id);


--
-- Name: orders orders_pkey; Type: CONSTRAINT; Schema: public; Owner: alpargatetech_db_user
--

ALTER TABLE ONLY public.orders
    ADD CONSTRAINT orders_pkey PRIMARY KEY (id);


--
-- Name: password_reset_codes password_reset_codes_pkey; Type: CONSTRAINT; Schema: public; Owner: alpargatetech_db_user
--

ALTER TABLE ONLY public.password_reset_codes
    ADD CONSTRAINT password_reset_codes_pkey PRIMARY KEY (id);


--
-- Name: password_reset_tokens password_reset_tokens_pkey; Type: CONSTRAINT; Schema: public; Owner: alpargatetech_db_user
--

ALTER TABLE ONLY public.password_reset_tokens
    ADD CONSTRAINT password_reset_tokens_pkey PRIMARY KEY (email);


--
-- Name: payments payments_pkey; Type: CONSTRAINT; Schema: public; Owner: alpargatetech_db_user
--

ALTER TABLE ONLY public.payments
    ADD CONSTRAINT payments_pkey PRIMARY KEY (id);


--
-- Name: products products_pkey; Type: CONSTRAINT; Schema: public; Owner: alpargatetech_db_user
--

ALTER TABLE ONLY public.products
    ADD CONSTRAINT products_pkey PRIMARY KEY (id);


--
-- Name: recipes recipes_pkey; Type: CONSTRAINT; Schema: public; Owner: alpargatetech_db_user
--

ALTER TABLE ONLY public.recipes
    ADD CONSTRAINT recipes_pkey PRIMARY KEY (id);


--
-- Name: sessions sessions_pkey; Type: CONSTRAINT; Schema: public; Owner: alpargatetech_db_user
--

ALTER TABLE ONLY public.sessions
    ADD CONSTRAINT sessions_pkey PRIMARY KEY (id);


--
-- Name: tables tables_number_unique; Type: CONSTRAINT; Schema: public; Owner: alpargatetech_db_user
--

ALTER TABLE ONLY public.tables
    ADD CONSTRAINT tables_number_unique UNIQUE (number);


--
-- Name: tables tables_pkey; Type: CONSTRAINT; Schema: public; Owner: alpargatetech_db_user
--

ALTER TABLE ONLY public.tables
    ADD CONSTRAINT tables_pkey PRIMARY KEY (id);


--
-- Name: users users_email_unique; Type: CONSTRAINT; Schema: public; Owner: alpargatetech_db_user
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_email_unique UNIQUE (email);


--
-- Name: users users_pkey; Type: CONSTRAINT; Schema: public; Owner: alpargatetech_db_user
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pkey PRIMARY KEY (id);


--
-- Name: jobs_queue_index; Type: INDEX; Schema: public; Owner: alpargatetech_db_user
--

CREATE INDEX jobs_queue_index ON public.jobs USING btree (queue);


--
-- Name: password_reset_codes_email_index; Type: INDEX; Schema: public; Owner: alpargatetech_db_user
--

CREATE INDEX password_reset_codes_email_index ON public.password_reset_codes USING btree (email);


--
-- Name: sessions_last_activity_index; Type: INDEX; Schema: public; Owner: alpargatetech_db_user
--

CREATE INDEX sessions_last_activity_index ON public.sessions USING btree (last_activity);


--
-- Name: sessions_user_id_index; Type: INDEX; Schema: public; Owner: alpargatetech_db_user
--

CREATE INDEX sessions_user_id_index ON public.sessions USING btree (user_id);


--
-- Name: order_items order_items_order_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: alpargatetech_db_user
--

ALTER TABLE ONLY public.order_items
    ADD CONSTRAINT order_items_order_id_foreign FOREIGN KEY (order_id) REFERENCES public.orders(id) ON DELETE CASCADE;


--
-- Name: order_items order_items_product_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: alpargatetech_db_user
--

ALTER TABLE ONLY public.order_items
    ADD CONSTRAINT order_items_product_id_foreign FOREIGN KEY (product_id) REFERENCES public.products(id);


--
-- Name: orders orders_table_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: alpargatetech_db_user
--

ALTER TABLE ONLY public.orders
    ADD CONSTRAINT orders_table_id_foreign FOREIGN KEY (table_id) REFERENCES public.tables(id);


--
-- Name: orders orders_user_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: alpargatetech_db_user
--

ALTER TABLE ONLY public.orders
    ADD CONSTRAINT orders_user_id_foreign FOREIGN KEY (user_id) REFERENCES public.users(id);


--
-- Name: payments payments_order_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: alpargatetech_db_user
--

ALTER TABLE ONLY public.payments
    ADD CONSTRAINT payments_order_id_foreign FOREIGN KEY (order_id) REFERENCES public.orders(id);


--
-- Name: products products_category_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: alpargatetech_db_user
--

ALTER TABLE ONLY public.products
    ADD CONSTRAINT products_category_id_foreign FOREIGN KEY (category_id) REFERENCES public.categories(id) ON DELETE CASCADE;


--
-- Name: recipes recipes_ingredient_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: alpargatetech_db_user
--

ALTER TABLE ONLY public.recipes
    ADD CONSTRAINT recipes_ingredient_id_foreign FOREIGN KEY (ingredient_id) REFERENCES public.ingredients(id) ON DELETE CASCADE;


--
-- Name: recipes recipes_product_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: alpargatetech_db_user
--

ALTER TABLE ONLY public.recipes
    ADD CONSTRAINT recipes_product_id_foreign FOREIGN KEY (product_id) REFERENCES public.products(id) ON DELETE CASCADE;


--
-- Name: SCHEMA public; Type: ACL; Schema: -; Owner: alpargatetech_db_user
--

REVOKE USAGE ON SCHEMA public FROM PUBLIC;


--
-- Name: DEFAULT PRIVILEGES FOR SEQUENCES; Type: DEFAULT ACL; Schema: -; Owner: postgres
--

ALTER DEFAULT PRIVILEGES FOR ROLE postgres GRANT ALL ON SEQUENCES TO alpargatetech_db_user;


--
-- Name: DEFAULT PRIVILEGES FOR TYPES; Type: DEFAULT ACL; Schema: -; Owner: postgres
--

ALTER DEFAULT PRIVILEGES FOR ROLE postgres GRANT ALL ON TYPES TO alpargatetech_db_user;


--
-- Name: DEFAULT PRIVILEGES FOR FUNCTIONS; Type: DEFAULT ACL; Schema: -; Owner: postgres
--

ALTER DEFAULT PRIVILEGES FOR ROLE postgres GRANT ALL ON FUNCTIONS TO alpargatetech_db_user;


--
-- Name: DEFAULT PRIVILEGES FOR TABLES; Type: DEFAULT ACL; Schema: -; Owner: postgres
--

ALTER DEFAULT PRIVILEGES FOR ROLE postgres GRANT ALL ON TABLES TO alpargatetech_db_user;


--
-- PostgreSQL database dump complete
--

\unrestrict hcEhfPfWUuzggD95BV14dAnPZvcIbUr9hBOpmrb4VnW2LeWpzMvjkOajTBwh70H

