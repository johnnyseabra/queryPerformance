<?php

namespace App\Providers;

use Doctrine\DBAL\DriverManager;
use Faker\Factory;
use Illuminate\Support\ServiceProvider;
use Throwable;

class ImportDatabaseServiceProvider extends ServiceProvider
{
   
    private $connection;
    
   
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
    
    
    public static function createTables(): bool
    {
             
        try 
        {
            $dbParams = config()->get('database.connections.pgsql');
            $connection = DriverManager::getConnection($dbParams);
            
            
            
            
            $sql = "
                CREATE TABLE public.tb_lists
                (
                    name character varying COLLATE pg_catalog.\"default\",
                    id smallserial NOT NULL,
                    CONSTRAINT tb_lists_pkey PRIMARY KEY (id)
                );";
            
            $connection->executeQuery($sql);
            
            $sql = "
                CREATE TABLE public.tb_people
                (
                    name character varying COLLATE pg_catalog.\"default\" NOT NULL,
                    id bigserial NOT NULL,
                    CONSTRAINT tb_people_pkey PRIMARY KEY (id)
                );";
            
            $connection->executeQuery($sql);
            
            $sql = "
                CREATE TABLE public.tb_people_belongs
                (
                    people integer NOT NULL,
                    list integer NOT NULL,
                    CONSTRAINT tb_list_people_pkey PRIMARY KEY (people, list),
                    CONSTRAINT fk_lists FOREIGN KEY (list)
                    REFERENCES public.tb_lists (id) MATCH SIMPLE
                    ON UPDATE NO ACTION
                    ON DELETE NO ACTION
                    NOT VALID,
                    CONSTRAINT fk_people FOREIGN KEY (people)
                    REFERENCES public.tb_people (id) MATCH SIMPLE
                    ON UPDATE NO ACTION
                    ON DELETE NO ACTION
                    NOT VALID

                );";
            
            $connection->executeQuery($sql);
            
            $sql = "
                CREATE TABLE public.tb_social_networks
                (
                    name character varying COLLATE pg_catalog.\"default\" NOT NULL,
                    id smallserial NOT NULL,
                    CONSTRAINT tb_social_networks_pkey PRIMARY KEY (id)
                );";
            
            $connection->executeQuery($sql);
            
            $sql = "
                CREATE TABLE public.tb_accounts
                (
                    people bigint NOT NULL,
                    id smallserial NOT NULL,
                    profile_link character varying COLLATE pg_catalog.\"default\",
                    social_network smallint,
                    CONSTRAINT tb_accounts_pkey PRIMARY KEY (id),
                    CONSTRAINT fk_people FOREIGN KEY (people)
                    REFERENCES public.tb_people (id) MATCH SIMPLE
                    ON UPDATE NO ACTION
                    ON DELETE NO ACTION
                    NOT VALID,
                    CONSTRAINT fk_social_network FOREIGN KEY (social_network)
                    REFERENCES public.tb_social_networks (id) MATCH SIMPLE
                    ON UPDATE NO ACTION
                    ON DELETE NO ACTION
                    NOT VALID
                );";
            
            $connection->executeQuery($sql);
            
            $sql = "
                CREATE TABLE public.tb_posts
                (
                    account bigint NOT NULL,
                    date date,
                    link character varying COLLATE pg_catalog.\"default\",
                    id bigserial NOT NULL,
                    text character varying COLLATE pg_catalog.\"default\",
                    CONSTRAINT tb_posts_pkey PRIMARY KEY (id),
                    CONSTRAINT fk_account FOREIGN KEY (account)
                    REFERENCES public.tb_accounts (id) MATCH SIMPLE
                    ON UPDATE NO ACTION
                    ON DELETE NO ACTION
                    NOT VALID
                );";
            
            $connection->executeQuery($sql);
            
            return true;
        }
        
        catch(Throwable $e)
        {
            report ($e);
            
            return false;
        }
        
        
    }
    
    
    public static function createMaterializedView():bool
    {
        try {
            
        
        
            $sql = "
                    CREATE MATERIALIZED VIEW public.mv_posts
                    TABLESPACE pg_default
                    AS
                     SELECT p.name AS people_name,
                        tb_lists.name AS list_name,
                        tb_social_networks.name AS social_network,
                        tb_accounts.profile_link,
                        tb_posts.date AS post_date,
                        tb_posts.text AS post_text,
                        tb_posts.link AS post_link,
                        ( SELECT string_agg(tb_lists_1.name::text, '| '::text) AS lists
                               FROM tb_lists tb_lists_1
                                 JOIN tb_people_belongs tb_people_belongs_1 ON tb_people_belongs_1.list = tb_lists_1.id
                                 JOIN tb_people ON tb_people.id = tb_people_belongs_1.people
                              WHERE p.name::text = tb_people.name::text
                              GROUP BY tb_people.name) AS lists
                       FROM tb_posts
                         JOIN tb_accounts ON tb_accounts.id = tb_posts.account
                         JOIN tb_people p ON p.id = tb_accounts.people
                         JOIN tb_social_networks ON tb_social_networks.id = tb_accounts.social_network
                         JOIN tb_people_belongs ON tb_people_belongs.people = p.id
                         JOIN tb_lists ON tb_people_belongs.list = tb_lists.id
                    WITH DATA;";
            
            $dbParams = config()->get('database.connections.pgsql');
            $connection = DriverManager::getConnection($dbParams);
            
            $connection->executeQuery($sql);
            
            //Creating index for date
            $sql = "
                    CREATE INDEX idx_date
                        ON public.mv_posts USING btree
                        (post_date ASC NULLS LAST)
                        TABLESPACE pg_default;";
            
            $connection->executeQuery($sql);
            
            //Creating index for list
            $sql = "
                    CREATE INDEX idx_list
                        ON public.mv_posts USING btree
                        (list_name COLLATE pg_catalog.\"default\" bpchar_pattern_ops ASC NULLS LAST)
                        TABLESPACE pg_default;";
            
            $connection->executeQuery($sql);
    
            //Creating index for social networks
            $sql = "
                   CREATE INDEX idx_social_network
                        ON public.mv_posts USING btree
                        (social_network COLLATE pg_catalog.\"default\" bpchar_pattern_ops ASC NULLS LAST)
                        TABLESPACE pg_default;";
            
            $connection->executeQuery($sql);
    
            //Creating index for social networks
            $sql = "
                   CREATE INDEX idx_text
                        ON public.mv_posts USING btree
                        (post_text COLLATE pg_catalog.\"default\" bpchar_pattern_ops ASC NULLS LAST)
                        TABLESPACE pg_default;";
            
            $connection->executeQuery($sql);
            
            return true;
        }
        catch (Throwable $e)
        {
            report ($e);
            
            return false;
        }
    }
}
