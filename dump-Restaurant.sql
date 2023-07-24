--
-- PostgreSQL database dump
--

-- Dumped from database version 15.3 (Ubuntu 15.3-0ubuntu0.23.04.1)
-- Dumped by pg_dump version 15.3 (Ubuntu 15.3-0ubuntu0.23.04.1)

-- Started on 2023-07-24 18:01:51 CEST

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

--
-- TOC entry 5 (class 2615 OID 2200)
-- Name: public; Type: SCHEMA; Schema: -; Owner: -
--

CREATE SCHEMA public;


--
-- TOC entry 3452 (class 0 OID 0)
-- Dependencies: 5
-- Name: SCHEMA public; Type: COMMENT; Schema: -; Owner: -
--

COMMENT ON SCHEMA public IS 'standard public schema';


SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- TOC entry 220 (class 1259 OID 16462)
-- Name: foods; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.foods (
    id integer NOT NULL,
    name character varying(50),
    quantity integer NOT NULL,
    CONSTRAINT foods_quantity_check CHECK ((quantity >= 0))
);


--
-- TOC entry 219 (class 1259 OID 16461)
-- Name: foods_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.foods_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 3453 (class 0 OID 0)
-- Dependencies: 219
-- Name: foods_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.foods_id_seq OWNED BY public.foods.id;


--
-- TOC entry 216 (class 1259 OID 16439)
-- Name: groups; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.groups (
    id integer NOT NULL,
    name character varying(50) NOT NULL
);


--
-- TOC entry 215 (class 1259 OID 16438)
-- Name: groups_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.groups_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 3454 (class 0 OID 0)
-- Dependencies: 215
-- Name: groups_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.groups_id_seq OWNED BY public.groups.id;


--
-- TOC entry 224 (class 1259 OID 16495)
-- Name: orders; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.orders (
    id integer NOT NULL,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    status character varying(10) NOT NULL,
    about text,
    user_id integer,
    food_id integer
);


--
-- TOC entry 223 (class 1259 OID 16494)
-- Name: orders_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.orders_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 3455 (class 0 OID 0)
-- Dependencies: 223
-- Name: orders_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.orders_id_seq OWNED BY public.orders.id;


--
-- TOC entry 222 (class 1259 OID 16470)
-- Name: price_list; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.price_list (
    id integer NOT NULL,
    food_id integer NOT NULL,
    price integer NOT NULL,
    CONSTRAINT price_list_price_check CHECK ((price >= 0))
);


--
-- TOC entry 221 (class 1259 OID 16469)
-- Name: price_list_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.price_list_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 3456 (class 0 OID 0)
-- Dependencies: 221
-- Name: price_list_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.price_list_id_seq OWNED BY public.price_list.id;


--
-- TOC entry 227 (class 1259 OID 16521)
-- Name: resttables; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.resttables (
    id integer NOT NULL,
    ordersid integer NOT NULL,
    isused boolean
);


--
-- TOC entry 225 (class 1259 OID 16519)
-- Name: resttables_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.resttables_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 3457 (class 0 OID 0)
-- Dependencies: 225
-- Name: resttables_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.resttables_id_seq OWNED BY public.resttables.id;


--
-- TOC entry 226 (class 1259 OID 16520)
-- Name: resttables_ordersid_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.resttables_ordersid_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 3458 (class 0 OID 0)
-- Dependencies: 226
-- Name: resttables_ordersid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.resttables_ordersid_seq OWNED BY public.resttables.ordersid;


--
-- TOC entry 218 (class 1259 OID 16446)
-- Name: users; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.users (
    id integer NOT NULL,
    email character varying(100) NOT NULL,
    password text NOT NULL,
    firstname character varying(50) NOT NULL,
    lastname character varying(50) NOT NULL,
    group_id integer
);


--
-- TOC entry 217 (class 1259 OID 16445)
-- Name: users_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.users_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 3459 (class 0 OID 0)
-- Dependencies: 217
-- Name: users_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.users_id_seq OWNED BY public.users.id;


--
-- TOC entry 3264 (class 2604 OID 16465)
-- Name: foods id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.foods ALTER COLUMN id SET DEFAULT nextval('public.foods_id_seq'::regclass);


--
-- TOC entry 3262 (class 2604 OID 16442)
-- Name: groups id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.groups ALTER COLUMN id SET DEFAULT nextval('public.groups_id_seq'::regclass);


--
-- TOC entry 3266 (class 2604 OID 16498)
-- Name: orders id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.orders ALTER COLUMN id SET DEFAULT nextval('public.orders_id_seq'::regclass);


--
-- TOC entry 3265 (class 2604 OID 16473)
-- Name: price_list id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.price_list ALTER COLUMN id SET DEFAULT nextval('public.price_list_id_seq'::regclass);


--
-- TOC entry 3268 (class 2604 OID 16524)
-- Name: resttables id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.resttables ALTER COLUMN id SET DEFAULT nextval('public.resttables_id_seq'::regclass);


--
-- TOC entry 3263 (class 2604 OID 16449)
-- Name: users id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.users ALTER COLUMN id SET DEFAULT nextval('public.users_id_seq'::regclass);


--
-- TOC entry 3439 (class 0 OID 16462)
-- Dependencies: 220
-- Data for Name: foods; Type: TABLE DATA; Schema: public; Owner: -
--

INSERT INTO public.foods VALUES (1, 'Fries', 100);
INSERT INTO public.foods VALUES (2, 'Steak', 50);
INSERT INTO public.foods VALUES (3, 'goulash', 150);
INSERT INTO public.foods VALUES (4, 'cola', 300);
INSERT INTO public.foods VALUES (5, 'panini', 100);
INSERT INTO public.foods VALUES (6, 'spaghetti', 200);
INSERT INTO public.foods VALUES (7, 'hamburger', 300);
INSERT INTO public.foods VALUES (8, 'apple pie', 120);
INSERT INTO public.foods VALUES (-1, 'None', 0);


--
-- TOC entry 3435 (class 0 OID 16439)
-- Dependencies: 216
-- Data for Name: groups; Type: TABLE DATA; Schema: public; Owner: -
--

INSERT INTO public.groups VALUES (1, 'Admin');
INSERT INTO public.groups VALUES (2, 'Manager');
INSERT INTO public.groups VALUES (3, 'Customer');
INSERT INTO public.groups VALUES (4, 'Chef');


--
-- TOC entry 3443 (class 0 OID 16495)
-- Dependencies: 224
-- Data for Name: orders; Type: TABLE DATA; Schema: public; Owner: -
--

INSERT INTO public.orders VALUES (3, '2023-07-20 13:00:30.044237', 'waiting', NULL, 13, 1);
INSERT INTO public.orders VALUES (4, '2023-07-20 13:00:30.058833', 'waiting', NULL, 13, 3);
INSERT INTO public.orders VALUES (5, '2023-07-20 13:00:30.067048', 'served', NULL, 14, 5);
INSERT INTO public.orders VALUES (6, '2023-07-20 13:00:30.075178', 'paid', NULL, 13, 6);
INSERT INTO public.orders VALUES (-1, '2023-07-23 23:24:32.615849', 'none', NULL, 13, -1);
INSERT INTO public.orders VALUES (36, '2023-07-24 00:27:21.188232', 'pending', 'idk', 13, 8);


--
-- TOC entry 3441 (class 0 OID 16470)
-- Dependencies: 222
-- Data for Name: price_list; Type: TABLE DATA; Schema: public; Owner: -
--

INSERT INTO public.price_list VALUES (1, 1, 50);
INSERT INTO public.price_list VALUES (2, 2, 200);
INSERT INTO public.price_list VALUES (3, 3, 120);
INSERT INTO public.price_list VALUES (4, 4, 30);
INSERT INTO public.price_list VALUES (5, 5, 140);
INSERT INTO public.price_list VALUES (6, 6, 100);
INSERT INTO public.price_list VALUES (7, 7, 110);
INSERT INTO public.price_list VALUES (8, 8, 139);


--
-- TOC entry 3446 (class 0 OID 16521)
-- Dependencies: 227
-- Data for Name: resttables; Type: TABLE DATA; Schema: public; Owner: -
--

INSERT INTO public.resttables VALUES (13, 6, false);
INSERT INTO public.resttables VALUES (14, 5, true);
INSERT INTO public.resttables VALUES (46, 3, true);
INSERT INTO public.resttables VALUES (12, 4, true);
INSERT INTO public.resttables VALUES (51, -1, false);


--
-- TOC entry 3437 (class 0 OID 16446)
-- Dependencies: 218
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: -
--

INSERT INTO public.users VALUES (13, 'mail@mail.com', '$2y$10$sSXgbw.FUDhBHoVUkIoRjeLOS7AgENfdOnTN8.oxVD4eX8Qb6m5zW', 'Jakub', 'Kurka', 2);
INSERT INTO public.users VALUES (14, 'TailsLover69@SonicBoom.com', '$2y$10$1krxyUyb6aWvbeuYbrunnerGm.QY4GPoIrUvqvmh39TOXMO1lRmEu', 'Martin', 'Mach', 2);


--
-- TOC entry 3460 (class 0 OID 0)
-- Dependencies: 219
-- Name: foods_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.foods_id_seq', 33, true);


--
-- TOC entry 3461 (class 0 OID 0)
-- Dependencies: 215
-- Name: groups_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.groups_id_seq', 6, true);


--
-- TOC entry 3462 (class 0 OID 0)
-- Dependencies: 223
-- Name: orders_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.orders_id_seq', 36, true);


--
-- TOC entry 3463 (class 0 OID 0)
-- Dependencies: 221
-- Name: price_list_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.price_list_id_seq', 33, true);


--
-- TOC entry 3464 (class 0 OID 0)
-- Dependencies: 225
-- Name: resttables_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.resttables_id_seq', 53, true);


--
-- TOC entry 3465 (class 0 OID 0)
-- Dependencies: 226
-- Name: resttables_ordersid_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.resttables_ordersid_seq', 5, true);


--
-- TOC entry 3466 (class 0 OID 0)
-- Dependencies: 217
-- Name: users_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.users_id_seq', 14, true);


--
-- TOC entry 3278 (class 2606 OID 16468)
-- Name: foods foods_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.foods
    ADD CONSTRAINT foods_pkey PRIMARY KEY (id);


--
-- TOC entry 3272 (class 2606 OID 16444)
-- Name: groups groups_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.groups
    ADD CONSTRAINT groups_pkey PRIMARY KEY (id);


--
-- TOC entry 3282 (class 2606 OID 16503)
-- Name: orders orders_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.orders
    ADD CONSTRAINT orders_pkey PRIMARY KEY (id);


--
-- TOC entry 3284 (class 2606 OID 16531)
-- Name: resttables ordersid_fk; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.resttables
    ADD CONSTRAINT ordersid_fk UNIQUE (ordersid);


--
-- TOC entry 3280 (class 2606 OID 16476)
-- Name: price_list price_list_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.price_list
    ADD CONSTRAINT price_list_pkey PRIMARY KEY (id);


--
-- TOC entry 3286 (class 2606 OID 16529)
-- Name: resttables resttables_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.resttables
    ADD CONSTRAINT resttables_pkey PRIMARY KEY (id);


--
-- TOC entry 3274 (class 2606 OID 16455)
-- Name: users users_email_key; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_email_key UNIQUE (email);


--
-- TOC entry 3276 (class 2606 OID 16453)
-- Name: users users_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pkey PRIMARY KEY (id);


--
-- TOC entry 3288 (class 2606 OID 16477)
-- Name: price_list fk_food_id; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.price_list
    ADD CONSTRAINT fk_food_id FOREIGN KEY (food_id) REFERENCES public.foods(id);


--
-- TOC entry 3287 (class 2606 OID 16456)
-- Name: users fk_group; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT fk_group FOREIGN KEY (group_id) REFERENCES public.groups(id);


--
-- TOC entry 3289 (class 2606 OID 16539)
-- Name: orders foods_fk; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.orders
    ADD CONSTRAINT foods_fk FOREIGN KEY (food_id) REFERENCES public.foods(id);


--
-- TOC entry 3291 (class 2606 OID 16532)
-- Name: resttables resttables_fk; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.resttables
    ADD CONSTRAINT resttables_fk FOREIGN KEY (ordersid) REFERENCES public.orders(id);


--
-- TOC entry 3290 (class 2606 OID 16544)
-- Name: orders users_fk; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.orders
    ADD CONSTRAINT users_fk FOREIGN KEY (user_id) REFERENCES public.users(id);


-- Completed on 2023-07-24 18:01:52 CEST

--
-- PostgreSQL database dump complete
--

