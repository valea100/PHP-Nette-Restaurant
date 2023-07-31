--
-- PostgreSQL database dump
--

-- Dumped from database version 15.3 (Ubuntu 15.3-0ubuntu0.23.04.1)
-- Dumped by pg_dump version 15.3 (Ubuntu 15.3-0ubuntu0.23.04.1)

-- Started on 2023-07-31 21:00:32 CEST

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
-- TOC entry 3463 (class 0 OID 0)
-- Dependencies: 5
-- Name: SCHEMA public; Type: COMMENT; Schema: -; Owner: -
--

COMMENT ON SCHEMA public IS 'standard public schema';


SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- TOC entry 229 (class 1259 OID 24732)
-- Name: food_images; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.food_images (
    id integer NOT NULL,
    height integer NOT NULL,
    width integer NOT NULL,
    food_id integer,
    about integer[],
    link text NOT NULL,
    filename character varying
);


--
-- TOC entry 228 (class 1259 OID 24731)
-- Name: food_images_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.food_images_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 3464 (class 0 OID 0)
-- Dependencies: 228
-- Name: food_images_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.food_images_id_seq OWNED BY public.food_images.id;


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
-- TOC entry 3465 (class 0 OID 0)
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
-- TOC entry 3466 (class 0 OID 0)
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
-- TOC entry 3467 (class 0 OID 0)
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
-- TOC entry 3468 (class 0 OID 0)
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
    ordersid integer,
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
-- TOC entry 3469 (class 0 OID 0)
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
-- TOC entry 3470 (class 0 OID 0)
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
-- TOC entry 3471 (class 0 OID 0)
-- Dependencies: 217
-- Name: users_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.users_id_seq OWNED BY public.users.id;


--
-- TOC entry 3274 (class 2604 OID 24735)
-- Name: food_images id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.food_images ALTER COLUMN id SET DEFAULT nextval('public.food_images_id_seq'::regclass);


--
-- TOC entry 3269 (class 2604 OID 16465)
-- Name: foods id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.foods ALTER COLUMN id SET DEFAULT nextval('public.foods_id_seq'::regclass);


--
-- TOC entry 3267 (class 2604 OID 16442)
-- Name: groups id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.groups ALTER COLUMN id SET DEFAULT nextval('public.groups_id_seq'::regclass);


--
-- TOC entry 3271 (class 2604 OID 16498)
-- Name: orders id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.orders ALTER COLUMN id SET DEFAULT nextval('public.orders_id_seq'::regclass);


--
-- TOC entry 3270 (class 2604 OID 16473)
-- Name: price_list id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.price_list ALTER COLUMN id SET DEFAULT nextval('public.price_list_id_seq'::regclass);


--
-- TOC entry 3273 (class 2604 OID 16524)
-- Name: resttables id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.resttables ALTER COLUMN id SET DEFAULT nextval('public.resttables_id_seq'::regclass);


--
-- TOC entry 3268 (class 2604 OID 16449)
-- Name: users id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.users ALTER COLUMN id SET DEFAULT nextval('public.users_id_seq'::regclass);


--
-- TOC entry 3457 (class 0 OID 24732)
-- Dependencies: 229
-- Data for Name: food_images; Type: TABLE DATA; Schema: public; Owner: -
--

INSERT INTO public.food_images VALUES (9, 510, 640, 50, NULL, 'img/6301980.png', '6301980');
INSERT INTO public.food_images VALUES (10, 1317, 1080, 51, NULL, 'img/6636792.png', '6636792');
INSERT INTO public.food_images VALUES (11, 2048, 1536, 52, NULL, 'img/3332942.png', '3332942');
INSERT INTO public.food_images VALUES (12, 1000, 1500, 53, NULL, 'img/6166059.png', '6166059');
INSERT INTO public.food_images VALUES (13, 460, 705, 54, NULL, 'img/7492833.png', '7492833');
INSERT INTO public.food_images VALUES (14, 800, 1200, 55, NULL, 'img/2428908.png', '2428908');
INSERT INTO public.food_images VALUES (15, 1444, 1524, 56, NULL, 'img/11515637.png', '11515637');


--
-- TOC entry 3448 (class 0 OID 16462)
-- Dependencies: 220
-- Data for Name: foods; Type: TABLE DATA; Schema: public; Owner: -
--

INSERT INTO public.foods VALUES (50, 'Old Router', 2);
INSERT INTO public.foods VALUES (51, 'snoop dogg', 420);
INSERT INTO public.foods VALUES (52, 'Snídaně', 40);
INSERT INTO public.foods VALUES (53, 'Spaghetti', 100);
INSERT INTO public.foods VALUES (54, 'Hamburger', 80);
INSERT INTO public.foods VALUES (55, 'Pizza', 200);
INSERT INTO public.foods VALUES (56, 'Svíčková', 75);


--
-- TOC entry 3444 (class 0 OID 16439)
-- Dependencies: 216
-- Data for Name: groups; Type: TABLE DATA; Schema: public; Owner: -
--

INSERT INTO public.groups VALUES (1, 'Admin');
INSERT INTO public.groups VALUES (2, 'Manager');
INSERT INTO public.groups VALUES (3, 'Customer');
INSERT INTO public.groups VALUES (4, 'Chef');


--
-- TOC entry 3452 (class 0 OID 16495)
-- Dependencies: 224
-- Data for Name: orders; Type: TABLE DATA; Schema: public; Owner: -
--

INSERT INTO public.orders VALUES (37, '2023-07-31 18:44:12.623341', 'pending', 'idk', 13, 52);
INSERT INTO public.orders VALUES (38, '2023-07-31 18:44:17.466171', 'pending', 'idk', 13, 50);


--
-- TOC entry 3450 (class 0 OID 16470)
-- Dependencies: 222
-- Data for Name: price_list; Type: TABLE DATA; Schema: public; Owner: -
--

INSERT INTO public.price_list VALUES (35, 50, 500);
INSERT INTO public.price_list VALUES (37, 52, 666);
INSERT INTO public.price_list VALUES (38, 53, 120);
INSERT INTO public.price_list VALUES (39, 54, 160);
INSERT INTO public.price_list VALUES (40, 55, 180);
INSERT INTO public.price_list VALUES (36, 51, 69);
INSERT INTO public.price_list VALUES (43, 56, 300);


--
-- TOC entry 3455 (class 0 OID 16521)
-- Dependencies: 227
-- Data for Name: resttables; Type: TABLE DATA; Schema: public; Owner: -
--

INSERT INTO public.resttables VALUES (60, NULL, false);
INSERT INTO public.resttables VALUES (61, NULL, false);


--
-- TOC entry 3446 (class 0 OID 16446)
-- Dependencies: 218
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: -
--

INSERT INTO public.users VALUES (13, 'mail@mail.com', '$2y$10$sSXgbw.FUDhBHoVUkIoRjeLOS7AgENfdOnTN8.oxVD4eX8Qb6m5zW', 'Jakub', 'Kurka', 2);
INSERT INTO public.users VALUES (14, 'TailsLover69@SonicBoom.com', '$2y$10$1krxyUyb6aWvbeuYbrunnerGm.QY4GPoIrUvqvmh39TOXMO1lRmEu', 'Martin', 'Mach', 2);


--
-- TOC entry 3472 (class 0 OID 0)
-- Dependencies: 228
-- Name: food_images_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.food_images_id_seq', 15, true);


--
-- TOC entry 3473 (class 0 OID 0)
-- Dependencies: 219
-- Name: foods_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.foods_id_seq', 56, true);


--
-- TOC entry 3474 (class 0 OID 0)
-- Dependencies: 215
-- Name: groups_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.groups_id_seq', 6, true);


--
-- TOC entry 3475 (class 0 OID 0)
-- Dependencies: 223
-- Name: orders_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.orders_id_seq', 38, true);


--
-- TOC entry 3476 (class 0 OID 0)
-- Dependencies: 221
-- Name: price_list_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.price_list_id_seq', 43, true);


--
-- TOC entry 3477 (class 0 OID 0)
-- Dependencies: 225
-- Name: resttables_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.resttables_id_seq', 61, true);


--
-- TOC entry 3478 (class 0 OID 0)
-- Dependencies: 226
-- Name: resttables_ordersid_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.resttables_ordersid_seq', 5, true);


--
-- TOC entry 3479 (class 0 OID 0)
-- Dependencies: 217
-- Name: users_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.users_id_seq', 14, true);


--
-- TOC entry 3294 (class 2606 OID 24744)
-- Name: food_images food_images_pk; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.food_images
    ADD CONSTRAINT food_images_pk PRIMARY KEY (id);


--
-- TOC entry 3284 (class 2606 OID 16468)
-- Name: foods foods_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.foods
    ADD CONSTRAINT foods_pkey PRIMARY KEY (id);


--
-- TOC entry 3278 (class 2606 OID 16444)
-- Name: groups groups_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.groups
    ADD CONSTRAINT groups_pkey PRIMARY KEY (id);


--
-- TOC entry 3288 (class 2606 OID 16503)
-- Name: orders orders_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.orders
    ADD CONSTRAINT orders_pkey PRIMARY KEY (id);


--
-- TOC entry 3290 (class 2606 OID 16531)
-- Name: resttables ordersid_fk; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.resttables
    ADD CONSTRAINT ordersid_fk UNIQUE (ordersid);


--
-- TOC entry 3286 (class 2606 OID 16476)
-- Name: price_list price_list_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.price_list
    ADD CONSTRAINT price_list_pkey PRIMARY KEY (id);


--
-- TOC entry 3292 (class 2606 OID 16529)
-- Name: resttables resttables_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.resttables
    ADD CONSTRAINT resttables_pkey PRIMARY KEY (id);


--
-- TOC entry 3280 (class 2606 OID 16455)
-- Name: users users_email_key; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_email_key UNIQUE (email);


--
-- TOC entry 3282 (class 2606 OID 16453)
-- Name: users users_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pkey PRIMARY KEY (id);


--
-- TOC entry 3296 (class 2606 OID 16477)
-- Name: price_list fk_food_id; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.price_list
    ADD CONSTRAINT fk_food_id FOREIGN KEY (food_id) REFERENCES public.foods(id);


--
-- TOC entry 3295 (class 2606 OID 16456)
-- Name: users fk_group; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT fk_group FOREIGN KEY (group_id) REFERENCES public.groups(id);


--
-- TOC entry 3300 (class 2606 OID 24736)
-- Name: food_images food_images_fk; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.food_images
    ADD CONSTRAINT food_images_fk FOREIGN KEY (food_id) REFERENCES public.foods(id);


--
-- TOC entry 3297 (class 2606 OID 16539)
-- Name: orders foods_fk; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.orders
    ADD CONSTRAINT foods_fk FOREIGN KEY (food_id) REFERENCES public.foods(id);


--
-- TOC entry 3299 (class 2606 OID 16532)
-- Name: resttables resttables_fk; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.resttables
    ADD CONSTRAINT resttables_fk FOREIGN KEY (ordersid) REFERENCES public.orders(id);


--
-- TOC entry 3298 (class 2606 OID 16544)
-- Name: orders users_fk; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.orders
    ADD CONSTRAINT users_fk FOREIGN KEY (user_id) REFERENCES public.users(id);


-- Completed on 2023-07-31 21:00:32 CEST

--
-- PostgreSQL database dump complete
--

