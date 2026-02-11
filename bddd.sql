-- WARNING: This schema is for context only and is not meant to be run.
-- Table order and constraints may not be valid for execution.

CREATE TABLE public.cache (
  key character varying NOT NULL,
  value text NOT NULL,
  expiration integer NOT NULL,
  CONSTRAINT cache_pkey PRIMARY KEY (key)
);
CREATE TABLE public.cache_locks (
  key character varying NOT NULL,
  owner character varying NOT NULL,
  expiration integer NOT NULL,
  CONSTRAINT cache_locks_pkey PRIMARY KEY (key)
);
CREATE TABLE public.categories (
  id bigint NOT NULL DEFAULT nextval('categories_id_seq'::regclass),
  name character varying NOT NULL,
  created_at timestamp without time zone,
  updated_at timestamp without time zone,
  deleted_at timestamp without time zone,
  CONSTRAINT categories_pkey PRIMARY KEY (id)
);
CREATE TABLE public.clients (
  id bigint NOT NULL DEFAULT nextval('clients_id_seq'::regclass),
  name character varying NOT NULL,
  identification character varying,
  email character varying,
  phone character varying,
  created_at timestamp without time zone,
  updated_at timestamp without time zone,
  deleted_at timestamp without time zone,
  CONSTRAINT clients_pkey PRIMARY KEY (id)
);
CREATE TABLE public.failed_jobs (
  id bigint NOT NULL DEFAULT nextval('failed_jobs_id_seq'::regclass),
  uuid character varying NOT NULL UNIQUE,
  connection text NOT NULL,
  queue text NOT NULL,
  payload text NOT NULL,
  exception text NOT NULL,
  failed_at timestamp without time zone NOT NULL DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT failed_jobs_pkey PRIMARY KEY (id)
);
CREATE TABLE public.fixed_assets (
  id bigint NOT NULL DEFAULT nextval('fixed_assets_id_seq'::regclass),
  name character varying NOT NULL,
  description text,
  quantity integer NOT NULL,
  status character varying,
  created_at timestamp without time zone,
  updated_at timestamp without time zone,
  deleted_at timestamp without time zone,
  CONSTRAINT fixed_assets_pkey PRIMARY KEY (id)
);
CREATE TABLE public.ingredients (
  id bigint NOT NULL DEFAULT nextval('ingredients_id_seq'::regclass),
  name character varying NOT NULL,
  unit character varying NOT NULL,
  stock_actual numeric NOT NULL,
  stock_minimo numeric NOT NULL,
  created_at timestamp without time zone,
  updated_at timestamp without time zone,
  deleted_at timestamp without time zone,
  CONSTRAINT ingredients_pkey PRIMARY KEY (id)
);
CREATE TABLE public.job_batches (
  id character varying NOT NULL,
  name character varying NOT NULL,
  total_jobs integer NOT NULL,
  pending_jobs integer NOT NULL,
  failed_jobs integer NOT NULL,
  failed_job_ids text NOT NULL,
  options text,
  cancelled_at integer,
  created_at integer NOT NULL,
  finished_at integer,
  CONSTRAINT job_batches_pkey PRIMARY KEY (id)
);
CREATE TABLE public.jobs (
  id bigint NOT NULL DEFAULT nextval('jobs_id_seq'::regclass),
  queue character varying NOT NULL,
  payload text NOT NULL,
  attempts smallint NOT NULL,
  reserved_at integer,
  available_at integer NOT NULL,
  created_at integer NOT NULL,
  CONSTRAINT jobs_pkey PRIMARY KEY (id)
);
CREATE TABLE public.migrations (
  id integer NOT NULL DEFAULT nextval('migrations_id_seq'::regclass),
  migration character varying NOT NULL,
  batch integer NOT NULL,
  CONSTRAINT migrations_pkey PRIMARY KEY (id)
);
CREATE TABLE public.order_items (
  id bigint NOT NULL DEFAULT nextval('order_items_id_seq'::regclass),
  order_id bigint NOT NULL,
  product_id bigint NOT NULL,
  quantity integer NOT NULL,
  subtotal numeric NOT NULL,
  notes character varying,
  created_at timestamp without time zone,
  updated_at timestamp without time zone,
  deleted_at timestamp without time zone,
  CONSTRAINT order_items_pkey PRIMARY KEY (id),
  CONSTRAINT order_items_order_id_foreign FOREIGN KEY (order_id) REFERENCES public.orders(id),
  CONSTRAINT order_items_product_id_foreign FOREIGN KEY (product_id) REFERENCES public.products(id)
);
CREATE TABLE public.orders (
  id bigint NOT NULL DEFAULT nextval('orders_id_seq'::regclass),
  table_id bigint NOT NULL,
  user_id bigint,
  client_id bigint,
  status character varying NOT NULL DEFAULT 'Anotado'::character varying,
  total numeric NOT NULL DEFAULT '0'::numeric,
  created_at timestamp without time zone,
  updated_at timestamp without time zone,
  deleted_at timestamp without time zone,
  CONSTRAINT orders_pkey PRIMARY KEY (id),
  CONSTRAINT orders_table_id_foreign FOREIGN KEY (table_id) REFERENCES public.tables(id),
  CONSTRAINT orders_user_id_foreign FOREIGN KEY (user_id) REFERENCES public.users(id)
);
CREATE TABLE public.password_reset_codes (
  id bigint NOT NULL DEFAULT nextval('password_reset_codes_id_seq'::regclass),
  email character varying NOT NULL,
  code character varying NOT NULL,
  created_at timestamp without time zone,
  CONSTRAINT password_reset_codes_pkey PRIMARY KEY (id)
);
CREATE TABLE public.password_reset_tokens (
  email character varying NOT NULL,
  token character varying NOT NULL,
  created_at timestamp without time zone,
  CONSTRAINT password_reset_tokens_pkey PRIMARY KEY (email)
);
CREATE TABLE public.payments (
  id bigint NOT NULL DEFAULT nextval('payments_id_seq'::regclass),
  order_id bigint NOT NULL,
  amount numeric NOT NULL,
  payment_method character varying NOT NULL,
  paid_at timestamp without time zone,
  created_at timestamp without time zone,
  updated_at timestamp without time zone,
  deleted_at timestamp without time zone,
  CONSTRAINT payments_pkey PRIMARY KEY (id),
  CONSTRAINT payments_order_id_foreign FOREIGN KEY (order_id) REFERENCES public.orders(id)
);
CREATE TABLE public.products (
  id bigint NOT NULL DEFAULT nextval('products_id_seq'::regclass),
  category_id bigint NOT NULL,
  name character varying NOT NULL,
  price numeric NOT NULL,
  description text,
  stock integer DEFAULT 0,
  is_active boolean NOT NULL DEFAULT true,
  created_at timestamp without time zone,
  updated_at timestamp without time zone,
  deleted_at timestamp without time zone,
  CONSTRAINT products_pkey PRIMARY KEY (id),
  CONSTRAINT products_category_id_foreign FOREIGN KEY (category_id) REFERENCES public.categories(id)
);
CREATE TABLE public.recipes (
  id bigint NOT NULL DEFAULT nextval('recipes_id_seq'::regclass),
  product_id bigint NOT NULL,
  ingredient_id bigint NOT NULL,
  quantity_required numeric NOT NULL,
  created_at timestamp without time zone,
  updated_at timestamp without time zone,
  deleted_at timestamp without time zone,
  CONSTRAINT recipes_pkey PRIMARY KEY (id),
  CONSTRAINT recipes_ingredient_id_foreign FOREIGN KEY (ingredient_id) REFERENCES public.ingredients(id),
  CONSTRAINT recipes_product_id_foreign FOREIGN KEY (product_id) REFERENCES public.products(id)
);
CREATE TABLE public.sessions (
  id character varying NOT NULL,
  user_id bigint,
  ip_address character varying,
  user_agent text,
  payload text NOT NULL,
  last_activity integer NOT NULL,
  CONSTRAINT sessions_pkey PRIMARY KEY (id)
);
CREATE TABLE public.tables (
  id bigint NOT NULL DEFAULT nextval('tables_id_seq'::regclass),
  number integer NOT NULL UNIQUE,
  capacity integer NOT NULL,
  status character varying NOT NULL DEFAULT 'Libre'::character varying,
  created_at timestamp without time zone,
  updated_at timestamp without time zone,
  deleted_at timestamp without time zone,
  CONSTRAINT tables_pkey PRIMARY KEY (id)
);
CREATE TABLE public.users (
  id bigint NOT NULL DEFAULT nextval('users_id_seq'::regclass),
  name character varying NOT NULL,
  email character varying NOT NULL UNIQUE,
  email_verified_at timestamp without time zone,
  password character varying NOT NULL,
  role character varying NOT NULL DEFAULT 'mesero'::character varying,
  remember_token character varying,
  created_at timestamp without time zone,
  updated_at timestamp without time zone,
  deleted_at timestamp without time zone,
  two_factor_code character varying,
  two_factor_expires_at timestamp without time zone,
  CONSTRAINT users_pkey PRIMARY KEY (id)
);