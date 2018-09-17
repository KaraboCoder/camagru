<?php
    include("database.php");
    try{
        $db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);

        //$stmt = $db->query("SHOW DATABASES");
       // var_dump($stmt->fetchAll(PDO::FETCH_ASSOC));

        #####################################################
        #                                                   #
        #                 CREATE DATABASE                   #
        #                                                   #
        #####################################################

        $db->exec("CREATE DATABASE camagru");

        ####################################################
        #                                                  #
        #               CREATE USERS TABLE                  #
        #                                                  #
        ####################################################

        $db->exec("
          CREATE TABLE `camagru`.`users`(
          `uid` INT NOT NULL AUTO_INCREMENT ,
          `password` VARCHAR(255) NOT NULL ,
          `email` VARCHAR(255) NOT NULL ,
          `username` VARCHAR(255) NOT NULL ,
          `verified` INT(1) NOT NULL DEFAULT '0',
          PRIMARY KEY (`uid`)) ENGINE = InnoDB;");


        ###################################################
        #                                                 #
        #              CREATE PHOTOS TABLE                #
        #                                                 #
        ###################################################

        $db->exec("
          CREATE TABLE `camagru`.`photos` (
          `photoid` INT NOT NULL AUTO_INCREMENT ,
          `uid` INT NOT NULL ,
          `url` VARCHAR(255) NOT NULL ,
          `timestamp` TIMESTAMP on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
          PRIMARY KEY (`photoid`, `uid`)) ENGINE = InnoDB;");


        ##################################################
        #                                                #
        #           CREATE COMMENTS TABLE                #
        #                                                #
        ##################################################

        $db->exec("
          CREATE TABLE `camagru`.`comments` (
          `id` INT NOT NULL AUTO_INCREMENT ,
          `photoid` INT NOT NULL ,
          `username` VARCHAR(255) NOT NULL ,
          `comment` TEXT NOT NULL ,
          `timestamp` TIMESTAMP on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
          PRIMARY KEY (`id`, `photoid`)) ENGINE = InnoDB;");


        #################################################
        #                                               #
        #           CREATE LIKES TABLE                  #
        #                                               #
        #################################################

        $db->exec("
          CREATE TABLE `camagru`.`likes` (
          `likeid` INT NOT NULL AUTO_INCREMENT ,
          `uid` INT NOT NULL ,
          `photoid` INT NOT NULL ,
          PRIMARY KEY (`likeid`, `uid`, `photoid`)) ENGINE = InnoDB;");


        #################################################
        #                                               #
        #           CREATE RESET TOKENS TABLE           #
        #                                               #
        #################################################

        $db->exec("
          CREATE TABLE `camagru`.`reset_tokens` (
          `email` VARCHAR(255) NOT NULL ,
          `token` VARCHAR(255) NOT NULL ) ENGINE = InnoDB;");

        ################################################
        #                                              #
        #              SELECT DATABASE                 #
        #                                              #
        ################################################

        $db->exec("USE camagru");

       // $stmt = $db->query("SHOW DATABASES");
        //var_dump($stmt->fetchAll(PDO::FETCH_ASSOC));
    }catch(PDOException $e){
        echo "Error ".$e->getMessage();
        die();
    }
?>