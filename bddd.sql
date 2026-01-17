--
-- PostgreSQL database dump
--

\restrict 331truq4nhwoMkhuJST1KH3c7KXfHs97vCgYrzBI5vcbCefIDAQgEiO6Lc5K5M4

-- Dumped from database version 18.1
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
-- Name: alpargatetech_db; Type: DATABASE; Schema: -; Owner: postgres
--

CREATE DATABASE alpargatetech_db WITH TEMPLATE = template0 ENCODING = 'UTF8' LOCALE_PROVIDER = libc LOCALE = 'en_GB.UTF-8';


ALTER DATABASE alpargatetech_db OWNER TO postgres;

\unrestrict 331truq4nhwoMkhuJST1KH3c7KXfHs97vCgYrzBI5vcbCefIDAQgEiO6Lc5K5M4
\connect alpargatetech_db
\restrict 331truq4nhwoMkhuJST1KH3c7KXfHs97vCgYrzBI5vcbCefIDAQgEiO6Lc5K5M4

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
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.users (id, name, email, password, role, remember_token, created_at, updated_at, deleted_at) FROM stdin;
1	Administrador de Prueba	admin@alfonso.com	$2y$12$iisdOqxKk/6.AkWd7cyAdugrRqW9ZGGDVH0MYZmqTLeLBdAwCkQ.K	admin	\N	2026-01-02 21:54:29	2026-01-02 21:54:29	\N
2	Mesero Juan	juan@alfonso.com	$2y$12$JtB/nrsWaUlH3xGXTxasweHKPaei7hC.BvcebU/T1jCCSNyTGujAe	mesero	\N	2026-01-02 23:04:41	2026-01-02 23:04:41	\N
3	Admin Principal	admin@resto.com	$2y$10$hashadmin	admin	\N	2026-01-02 23:52:18.046963	2026-01-02 23:52:18.046963	\N
4	Juan Mesero	mesero@resto.com	$2y$10$hashmesero	mesero	\N	2026-01-02 23:52:18.046963	2026-01-02 23:52:18.046963	\N
5	Carlos Cocina	cocinero@resto.com	$2y$10$hashcocina	cocinero	\N	2026-01-02 23:52:18.046963	2026-01-02 23:52:18.046963	\N
6	Cocinero Daro	LocoDaro@alfonso.com	$2y$12$UVd47M4WnYCp44toHSjT4el3.xfFHAcyny/H6vgXFqA1o5rVbwUY6	cocinero	\N	2026-01-03 03:14:00	2026-01-03 03:14:00	\N
\.


--
-- Data for Name: audit_logs; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.audit_logs (id, user_id, action, table_name, record_id, old_values, new_values, ip_address, user_agent, created_at) FROM stdin;
\.


--
-- Data for Name: cache; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.cache (key, value, expiration) FROM stdin;
\.


--
-- Data for Name: cache_locks; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.cache_locks (key, owner, expiration) FROM stdin;
\.


--
-- Data for Name: categories; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.categories (id, name, deleted_at) FROM stdin;
1	Bebidas	\N
2	Platos Fuertes	\N
3	Postres	\N
\.


--
-- Data for Name: clients; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.clients (id, name, identification, email, phone, deleted_at) FROM stdin;
1	Pedro Gómez	0102030405	pedro@gmail.com	0999999999	\N
2	María Torres	0607080910	maria@gmail.com	0988888888	\N
\.


--
-- Data for Name: failed_jobs; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.failed_jobs (id, uuid, connection, queue, payload, exception, failed_at) FROM stdin;
\.


--
-- Data for Name: fixed_assets; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.fixed_assets (id, name, description, quantity, status, deleted_at) FROM stdin;
1	Mesa Madera	Mesa para 4 personas	5	Buen estado	\N
2	Sillas	Sillas plásticas	20	Buen estado	\N
3	Horno	Horno industrial	1	Mantenimiento	\N
\.


--
-- Data for Name: ingredients; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.ingredients (id, name, unit, stock_actual, stock_minimo, deleted_at) FROM stdin;
1	Pan	unidad	50.00	10.00	\N
2	Carne	gr	5000.00	1000.00	\N
3	Queso	gr	3000.00	500.00	\N
4	Harina	gr	10000.00	2000.00	\N
5	Chocolate	gr	2000.00	300.00	\N
\.


--
-- Data for Name: job_batches; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.job_batches (id, name, total_jobs, pending_jobs, failed_jobs, failed_job_ids, options, cancelled_at, created_at, finished_at) FROM stdin;
\.


--
-- Data for Name: jobs; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.jobs (id, queue, payload, attempts, reserved_at, available_at, created_at) FROM stdin;
\.


--
-- Data for Name: migrations; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.migrations (id, migration, batch) FROM stdin;
1	0001_01_01_000001_create_cache_table	1
2	0001_01_01_000002_create_jobs_table	2
\.


--
-- Data for Name: tables; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.tables (id, number, capacity, status, deleted_at) FROM stdin;
6	7	4	Libre	\N
7	8	4	Libre	\N
3	4	4	Libre	\N
5	3	6	Libre	\N
1	1	4	Ocupada	\N
4	2	2	Libre	\N
\.


--
-- Data for Name: orders; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.orders (id, table_id, user_id, client_id, status, total, created_at, updated_at, deleted_at) FROM stdin;
39	1	2	\N	Entregado	8.00	2026-01-06 07:58:40.917389	2026-01-06 07:58:40.917389	\N
5	1	2	\N	Anotado	0.00	2026-01-02 19:19:55.886141	2026-01-02 19:19:55.886141	\N
6	5	2	\N	Anotado	0.00	2026-01-02 19:23:20.48943	2026-01-02 19:23:20.48943	\N
7	3	2	\N	Listo	0.00	2026-01-02 19:25:16.690044	2026-01-02 19:25:16.690044	\N
8	6	1	\N	Listo	0.00	2026-01-02 20:04:06.023956	2026-01-02 20:04:06.023956	\N
41	1	2	\N	Entregado	2.00	2026-01-06 09:33:40.960094	2026-01-06 09:33:40.960094	\N
9	7	1	\N	Listo	38.00	2026-01-02 20:10:00.693324	2026-01-02 20:10:00.693324	\N
11	4	1	\N	Anotado	0.00	2026-01-02 20:27:07.277571	2026-01-02 20:27:07.277571	\N
12	4	1	\N	Entregado	0.00	2026-01-02 20:29:10.797816	2026-01-02 20:29:10.797816	\N
10	1	1	\N	Listo	4.00	2026-01-02 20:14:42.41499	2026-01-02 20:14:42.41499	\N
4	1	2	2	Entregado	6.00	2026-01-02 23:55:21.213973	2026-01-02 23:55:21.213973	\N
25	7	1	\N	Entregado	24.00	2026-01-02 23:03:31.254126	2026-01-02 23:03:31.254126	\N
26	6	1	\N	Entregado	6.00	2026-01-02 23:06:11.189343	2026-01-02 23:06:11.189343	\N
23	3	1	\N	Entregado	8.00	2026-01-02 22:56:55.14021	2026-01-02 22:56:55.14021	\N
24	5	1	\N	Entregado	0.00	2026-01-02 23:03:21.396359	2026-01-02 23:03:21.396359	\N
22	4	1	\N	Entregado	6.00	2026-01-02 22:50:46.392892	2026-01-02 22:50:46.392892	\N
27	1	1	\N	Entregado	24.00	2026-01-02 23:14:28.691348	2026-01-02 23:14:28.691348	\N
14	3	2	\N	Entregado	27.00	2026-01-02 20:44:22.375868	2026-01-02 20:44:22.375868	\N
13	1	2	\N	Entregado	50.50	2026-01-02 20:43:33.286228	2026-01-02 20:43:33.286228	\N
16	4	1	\N	Listo	12.00	2026-01-02 20:49:08.725472	2026-01-02 20:49:08.725472	\N
15	1	1	\N	Entregado	10.00	2026-01-02 20:47:25.329679	2026-01-02 20:47:25.329679	\N
30	3	1	\N	Anotado	0.00	2026-01-02 23:24:42.355335	2026-01-02 23:24:42.355335	\N
31	3	1	\N	Anotado	0.00	2026-01-02 23:24:50.427425	2026-01-02 23:24:50.427425	\N
34	5	1	\N	Anotado	0.00	2026-01-02 23:41:46.179715	2026-01-02 23:41:46.179715	\N
45	3	1	\N	Entregado	11.50	2026-01-10 19:55:02.121443	2026-01-10 19:55:02.121443	\N
44	5	2	\N	Entregado	0.00	2026-01-06 09:34:46.896485	2026-01-06 09:34:46.896485	\N
43	4	2	\N	Entregado	8.50	2026-01-06 09:34:34.307559	2026-01-06 09:34:34.307559	\N
42	1	2	\N	Entregado	4.00	2026-01-06 09:34:21.001367	2026-01-06 09:34:21.001367	\N
19	7	1	\N	Entregado	8.00	2026-01-02 22:36:38.82434	2026-01-02 22:36:38.82434	\N
18	6	2	\N	Entregado	100.00	2026-01-02 22:31:54.342514	2026-01-02 22:31:54.342514	\N
17	3	2	\N	Entregado	31.00	2026-01-02 22:16:31.247701	2026-01-02 22:16:31.247701	\N
20	5	1	\N	Entregado	20.00	2026-01-02 22:36:55.290565	2026-01-02 22:36:55.290565	\N
3	4	2	1	Entregado	9.00	2026-01-02 23:55:21.213973	2026-01-02 23:55:21.213973	\N
21	1	1	\N	Entregado	8.00	2026-01-02 22:49:42.520002	2026-01-02 22:49:42.520002	\N
28	4	1	\N	Entregado	6.00	2026-01-02 23:21:32.840116	2026-01-02 23:21:32.840116	\N
35	5	1	\N	Entregado	12.00	2026-01-02 23:41:46.59485	2026-01-02 23:41:46.59485	\N
32	3	1	\N	Entregado	22.00	2026-01-02 23:24:56.058518	2026-01-02 23:24:56.058518	\N
29	6	1	\N	Entregado	8.00	2026-01-02 23:23:27.491676	2026-01-02 23:23:27.491676	\N
36	6	1	\N	Entregado	0.00	2026-01-06 07:36:28.76265	2026-01-06 07:36:28.76265	\N
46	1	2	\N	Entregado	3.50	2026-01-13 07:29:24.517896	2026-01-13 07:29:24.517896	\N
48	1	1	\N	Anotado	6.00	2026-01-13 07:32:50.591762	2026-01-13 07:32:50.591762	\N
47	4	2	\N	Entregado	0.00	2026-01-13 07:30:36.721481	2026-01-13 07:30:36.721481	\N
37	5	1	\N	Entregado	52.00	2026-01-06 07:36:40.41164	2026-01-06 07:36:40.41164	\N
33	7	1	\N	Entregado	16.00	2026-01-02 23:33:30.381121	2026-01-02 23:33:30.381121	\N
38	3	1	\N	Entregado	0.00	2026-01-06 07:46:11.702872	2026-01-06 07:46:11.702872	\N
40	4	2	\N	Entregado	6.50	2026-01-06 08:57:42.73375	2026-01-06 08:57:42.73375	\N
\.


--
-- Data for Name: products; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.products (id, category_id, name, description, price, is_active, deleted_at) FROM stdin;
1	1	Coca Cola	Bebida gaseosa 350ml	1.50	t	\N
2	1	Jugo Natural	Jugo de naranja	2.00	t	\N
3	2	Hamburguesa	Hamburguesa clásica	5.50	t	\N
4	2	Pizza Personal	Pizza de queso	6.00	t	\N
5	3	Pastel de Chocolate	Porción individual	3.00	t	\N
\.


--
-- Data for Name: order_items; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.order_items (id, order_id, product_id, quantity, notes, subtotal, deleted_at) FROM stdin;
4	3	3	1	Sin cebolla	5.50	\N
5	3	1	1	\N	1.50	\N
6	4	4	1	Extra queso	6.00	\N
7	9	1	4	\N	6.00	\N
8	9	2	4	\N	8.00	\N
9	9	4	3	\N	18.00	\N
10	9	5	2	\N	6.00	\N
11	10	2	2	\N	4.00	\N
12	13	1	0	\N	0.00	\N
13	13	1	2	\N	3.00	\N
14	13	2	5	\N	10.00	\N
15	13	4	2	\N	12.00	\N
16	13	3	3	\N	16.50	\N
17	13	5	3	\N	9.00	\N
18	14	2	2	\N	4.00	\N
19	14	4	0	\N	0.00	\N
20	14	4	2	\N	12.00	\N
21	14	3	2	\N	11.00	\N
22	15	2	5	\N	10.00	\N
23	16	4	2	\N	12.00	\N
24	17	2	9	\N	18.00	\N
25	17	1	2	\N	3.00	\N
26	18	2	50	\N	100.00	\N
27	17	2	3	\N	6.00	\N
28	17	2	2	\N	4.00	\N
29	19	2	4	\N	8.00	\N
30	20	2	10	\N	20.00	\N
31	21	2	4	\N	8.00	\N
32	22	2	3	\N	6.00	\N
33	23	2	4	\N	8.00	\N
34	25	4	4	\N	24.00	\N
35	26	2	3	\N	6.00	\N
36	27	4	4	\N	24.00	\N
37	28	2	3	\N	6.00	\N
38	29	2	4	\N	8.00	\N
39	32	2	3	\N	6.00	\N
40	32	2	8	\N	16.00	\N
41	33	2	8	\N	16.00	\N
42	35	2	6	\N	12.00	\N
43	37	1	3	\N	4.50	\N
44	37	4	3	\N	18.00	\N
45	37	3	1	\N	5.50	\N
46	37	4	4	\N	24.00	\N
47	37	1	0	\N	0.00	\N
48	39	2	1	\N	2.00	\N
49	39	4	1	\N	6.00	\N
50	40	2	1	\N	2.00	\N
51	40	1	3	\N	4.50	\N
52	41	2	1	\N	2.00	\N
53	42	2	1	\N	2.00	\N
54	42	2	1	\N	2.00	\N
55	43	1	1	\N	1.50	\N
56	43	1	1	\N	1.50	\N
57	43	3	1	\N	5.50	\N
58	45	1	1	\N	1.50	\N
59	45	2	1	\N	2.00	\N
60	45	2	1	\N	2.00	\N
61	45	4	1	\N	6.00	\N
62	46	2	1	\N	2.00	\N
63	46	1	1	\N	1.50	\N
64	48	4	1	\N	6.00	\N
\.


--
-- Data for Name: payments; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.payments (id, order_id, amount, payment_method, paid_at, deleted_at) FROM stdin;
2	12	0.00	Efectivo	2026-01-02 20:29:42.776065	\N
4	4	6.00	Transferencia	2026-01-02 20:30:41.846484	\N
5	14	27.00	Tarjeta	2026-01-02 20:46:58.744553	\N
6	13	50.50	Tarjeta	2026-01-02 20:47:08.515267	\N
8	15	10.00	Tarjeta	2026-01-02 20:49:32.687636	\N
10	19	8.00	Efectivo	2026-01-02 22:50:13.697536	\N
11	18	100.00	Efectivo	2026-01-02 22:50:16.511454	\N
12	17	31.00	Efectivo	2026-01-02 22:50:19.1159	\N
13	20	20.00	Efectivo	2026-01-02 22:50:21.631037	\N
14	3	9.00	Efectivo	2026-01-02 22:50:24.44421	\N
15	21	8.00	Efectivo	2026-01-02 22:50:27.356093	\N
16	25	24.00	Efectivo	2026-01-02 23:14:51.534864	\N
17	26	6.00	Efectivo	2026-01-02 23:14:54.19485	\N
18	23	8.00	Efectivo	2026-01-02 23:14:56.565334	\N
19	24	0.00	Efectivo	2026-01-02 23:15:02.162008	\N
20	22	6.00	Efectivo	2026-01-02 23:15:04.808024	\N
21	27	24.00	Efectivo	2026-01-02 23:15:07.46688	\N
22	28	6.00	Efectivo	2026-01-06 07:35:26.795315	\N
23	35	12.00	Efectivo	2026-01-06 07:35:30.822311	\N
24	32	22.00	Efectivo	2026-01-06 07:35:34.08468	\N
25	29	8.00	Efectivo	2026-01-06 07:35:47.323995	\N
26	36	0.00	Tarjeta	2026-01-06 07:37:17.415088	\N
27	37	52.00	Efectivo	2026-01-06 08:57:39.884567	\N
28	33	16.00	Efectivo	2026-01-06 09:31:09.421302	\N
29	38	0.00	Efectivo	2026-01-06 09:31:12.583751	\N
30	40	6.50	Efectivo	2026-01-06 09:31:16.391389	\N
31	39	8.00	Efectivo	2026-01-06 09:31:19.690058	\N
32	41	2.00	Efectivo	2026-01-06 09:33:48.015158	\N
33	45	11.50	Efectivo	2026-01-13 07:25:15.793894	\N
34	44	0.00	Efectivo	2026-01-13 07:25:18.955393	\N
35	43	8.50	Efectivo	2026-01-13 07:25:22.227442	\N
36	42	4.00	Efectivo	2026-01-13 07:25:42.642069	\N
37	46	3.50	Efectivo	2026-01-13 07:31:47.274225	\N
38	47	0.00	Tarjeta	2026-01-13 07:34:43.081351	\N
\.


--
-- Data for Name: recipes; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.recipes (id, product_id, ingredient_id, quantity_required, deleted_at) FROM stdin;
1	3	1	1.00	\N
2	3	2	150.00	\N
3	3	3	50.00	\N
4	4	4	200.00	\N
5	4	3	100.00	\N
6	5	4	100.00	\N
7	5	5	50.00	\N
\.


--
-- Data for Name: sessions_log; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.sessions_log (id, user_id, login_at, ip_address) FROM stdin;
1	1	2026-01-02 22:40:31	127.0.0.1
2	1	2026-01-02 22:56:32	127.0.0.1
3	1	2026-01-02 22:57:43	127.0.0.1
4	2	2026-01-02 23:05:11	127.0.0.1
5	2	2026-01-02 23:09:14	127.0.0.1
6	1	2026-01-02 23:39:51	127.0.0.1
7	2	2026-01-03 00:03:54	127.0.0.1
8	1	2026-01-03 00:42:07	127.0.0.1
9	1	2026-01-03 01:03:41	127.0.0.1
10	1	2026-01-03 01:42:42	192.168.1.16
11	2	2026-01-03 01:43:11	192.168.1.16
12	1	2026-01-03 01:45:49	192.168.1.16
13	6	2026-01-03 03:14:39	192.168.1.16
14	2	2026-01-03 03:16:07	192.168.1.5
15	1	2026-01-03 03:32:30	192.168.1.16
16	6	2026-01-03 03:48:48	127.0.0.1
17	1	2026-01-03 03:49:35	127.0.0.1
18	1	2026-01-03 04:32:08	192.168.1.5
19	6	2026-01-03 04:32:50	192.168.1.16
20	1	2026-01-06 12:35:05	127.0.0.1
21	2	2026-01-06 12:57:46	172.20.147.255
22	6	2026-01-06 12:58:28	172.20.157.241
23	6	2026-01-06 13:02:43	172.20.150.75
24	1	2026-01-06 13:15:48	172.20.157.241
25	1	2026-01-06 13:30:45	172.20.157.241
26	2	2026-01-06 13:57:08	172.20.147.255
27	1	2026-01-11 00:54:10	192.168.100.160
28	6	2026-01-11 00:54:39	192.168.100.164
29	6	2026-01-13 12:23:34	172.20.147.191
30	6	2026-01-13 12:24:07	172.20.147.191
31	2	2026-01-13 12:24:28	172.20.134.218
32	1	2026-01-13 12:26:24	172.20.131.209
33	1	2026-01-13 12:28:17	172.20.131.209
\.


--
-- Name: audit_logs_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.audit_logs_id_seq', 1, false);


--
-- Name: categories_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.categories_id_seq', 3, true);


--
-- Name: clients_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.clients_id_seq', 2, true);


--
-- Name: failed_jobs_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.failed_jobs_id_seq', 1, false);


--
-- Name: fixed_assets_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.fixed_assets_id_seq', 3, true);


--
-- Name: ingredients_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.ingredients_id_seq', 5, true);


--
-- Name: jobs_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.jobs_id_seq', 1, false);


--
-- Name: migrations_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.migrations_id_seq', 2, true);


--
-- Name: order_items_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.order_items_id_seq', 64, true);


--
-- Name: orders_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.orders_id_seq', 48, true);


--
-- Name: payments_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.payments_id_seq', 38, true);


--
-- Name: products_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.products_id_seq', 5, true);


--
-- Name: recipes_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.recipes_id_seq', 7, true);


--
-- Name: sessions_log_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.sessions_log_id_seq', 33, true);


--
-- Name: tables_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tables_id_seq', 7, true);


--
-- Name: users_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.users_id_seq', 6, true);


--
-- PostgreSQL database dump complete
--

\unrestrict 331truq4nhwoMkhuJST1KH3c7KXfHs97vCgYrzBI5vcbCefIDAQgEiO6Lc5K5M4

