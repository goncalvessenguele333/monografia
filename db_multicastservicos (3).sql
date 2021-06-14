-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 14, 2021 at 11:14 AM
-- Server version: 5.1.73
-- PHP Version: 7.3.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `db_multicastservicos`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`Adminms`@`%` PROCEDURE `anular_contrato` (`nr_contrato` INTEGER)  BEGIN
				DECLARE registos integer;
		SET registos=(SELECT COUNT(*) FROM tb_mensalidade_tmp WHERE cod_contrato =nr_contrato);		
		IF registos > 0 THEN
			DELETE from tb_mensalidade_tmp WHERE cod_contrato =nr_contrato;
            DELETE from tb_contrato WHERE cod_contato=nr_contrato;			 
		END IF;
							
						
				END$$

CREATE DEFINER=`Adminms`@`%` PROCEDURE `anular_factura` (`no_factura` INT)  BEGIN
			DECLARE registos integer;
	SET registos = (SELECT COUNT(*) FROM tb_factura WHERE nr_factura=no_factura and estado = 1);
		IF registos > 0 THEN
				
			UPDATE tb_factura SET estado = 2 WHERE nr_factura=no_factura;
			SELECT * FROM tb_factura WHERE nr_factura=no_factura;
			ELSE
	SELECT 0 tb_factura;	
	END IF;		
							
						
END$$

CREATE DEFINER=`Adminms`@`%` PROCEDURE `apaga_detalhe_contrato_temp` (`id_detalhe` INTEGER, `token_user` INTEGER)  BEGIN
	DELETE FROM tb_detalheContrato_temp WHERE correlativo=id_detalhe;
	SELECT *  FROM tb_detalheContrato_temp WHERE codUsuario=token_user;				
						
END$$

CREATE DEFINER=`Adminms`@`%` PROCEDURE `apaga_detalhe_temp` (`id_detalhe` INTEGER, `token_user` VARCHAR(100))  BEGIN
			DELETE FROM tb_detalhe_temp WHERE correlativo=id_detalhe;
						SELECT *  FROM tb_detalhe_temp WHERE token_user=token_user;				
						
END$$

CREATE DEFINER=`Adminms`@`%` PROCEDURE `apaga_detalhe_temp_cotacao` (`id_detalhe` INTEGER, `token_user` VARCHAR(100))  BEGIN
						DELETE FROM tb_detalhe_temp_cotacao WHERE correlativo=id_detalhe;
						SELECT *  FROM tb_detalhe_temp_cotacao WHERE token_user=token_user;
				END$$

CREATE DEFINER=`Adminms`@`%` PROCEDURE `apaga_mensalidade_temp` (IN `id_detalhe` INT, IN `nrContrato` INT)  BEGIN
						DELETE FROM tb_mensalidade_tmp WHERE correlativo=id_detalhe;
						
						SELECT * FROM tb_mensalidade_tmp WHERE cod_contrato=nrContrato;

				END$$

CREATE DEFINER=`Adminms`@`%` PROCEDURE `mensalidade` (IN `cod_contat` INT)  BEGIN		
		
				DECLARE registros integer;
								
				SET registros = (SELECT COUNT(*) FROM tb_mensalidade_tmp WHERE cod_contrato=cod_contat);
				IF registros > 0 THEN 

				INSERT INTO tb_mensalidade(cod_contato,nome_mes,estado,data_pagamento) SELECT cod_contrato,nome_mes,estado,dataPagamento
				FROM tb_mensalidade_tmp WHERE cod_contrato=cod_contat;
								
				
				DELETE FROM tb_mensalidade_tmp WHERE cod_contrato=cod_contat;
				
			SELECT * FROM tb_contrato c INNER JOIN tb_mensalidade m ON c.cod_contato=m.cod_contato WHERE m.cod_contato=cod_contat;
				ELSE
				SELECT 0;
				END IF;
		END$$

CREATE DEFINER=`Adminms`@`%` PROCEDURE `processar_contrato` (`tipoContrato` VARCHAR(100), `token` INTEGER, `codCliente` INTEGER, `valorTotal` DECIMAL(10,2), `valorMensal` DECIMAL(10,2), `dataAssinatura` VARCHAR(100), `dataInicio` VARCHAR(100), `dataVencimentoCont` VARCHAR(100), `duracoaContrat` INTEGER)  BEGIN
				DECLARE contrato integer;
				DECLARE registros integer;
						
				SET registros = (SELECT COUNT(*) FROM tb_detalheContrato_temp WHERE codUsuario=token);
				IF registros > 0 THEN 
				
				INSERT INTO tb_contrato(tipo_contrato,usuario,nr_cliente,valor_contrato,valor_prestacao,data_assinatura,data_inicio,data_vencimento,duracao_contrato) VALUES (tipoContrato,token,codCliente,valorTotal,valorMensal,dataAssinatura,dataInicio,dataVencimentoCont,duracoaContrat);
				SET contrato=LAST_INSERT_ID();
				INSERT INTO tb_detalhe_contrato (nr_contrato,cod_produto,description,quantidade,valor,valor_subtotal) SELECT (contrato) as nr_contrato,
				cod_produto,description,quantidade,valor,valor_subtotal FROM tb_detalheContrato_temp WHERE codUsuario =token;
				
				UPDATE tb_contrato SET estado='Em vigente' WHERE cod_contrato=contrato;
				UPDATE tb_contrato SET situacao='Novo' WHERE cod_contrato=contrato;
				
				INSERT INTO tb_controlo_recebimento_contrato(cod_contrato,Janeiro,Feverreiro,Marco,Abril,Maio,Junho,Julho,Agosto,Setembro,Outubro,Novembro,Dezembro,total)values(contrato,0,0,0,0,0,0,0,0,0,0,0,0,0);
				
				DELETE FROM tb_detalheContrato_temp WHERE codUsuario=token;
				SELECT * FROM tb_contrato WHERE cod_contrato=contrato;
				ELSE
				SELECT 0;
				END IF;
		END$$

CREATE DEFINER=`Adminms`@`%` PROCEDURE `processar_cotacao` (`cod_cliente` INTEGER, `token` VARCHAR(100), `iva_` INTEGER, `dataR` VARCHAR(50))  BEGIN
				DECLARE factura integer;
				DECLARE registros integer;
				DECLARE total_ decimal(10.2);
				DECLARE subtotal decimal(10.2);
				DECLARE iva decimal(10.2);
				
				
				SET registros = (SELECT COUNT(*) FROM tb_detalhe_temp_cotacao WHERE token_user=token);
				IF registros > 0 THEN 
				
				INSERT INTO tb_cotacao(usuario,cod_cliente,dataVenda) VALUES (token, cod_cliente,dataR);
				SET factura=LAST_INSERT_ID();
				INSERT INTO tb_detalhe_cotacao (nr_factura,cod_servico,description, quantidade,preco,subtotal_prod) SELECT (factura) as nr_factura,cod_servico,
				description, quantidade,preco,subtotal_prod FROM tb_detalhe_temp_cotacao WHERE token_user=token;
				
				UPDATE tb_cotacao SET motivo=1 WHERE nr_factura=factura;
				SET subtotal=(SELECT SUM(quantidade * preco) FROM tb_detalhe_temp_cotacao WHERE token_user= token);
				SET iva=(subtotal*iva_)/100;
				SET total_ =iva+subtotal;
				UPDATE tb_cotacao SET subtotal_factura=subtotal WHERE nr_factura=factura;
				UPDATE tb_cotacao SET iva_factura=iva WHERE nr_factura=factura;
				UPDATE tb_cotacao SET total_factura=total_ WHERE nr_factura=factura;
				
				DELETE FROM tb_detalhe_temp_cotacao WHERE token_user=token;
				SELECT * FROM tb_cotacao WHERE nr_factura=factura;
				ELSE
				SELECT 0;
				END IF;

		END$$

CREATE DEFINER=`Adminms`@`%` PROCEDURE `processar_factura` (`cod_cliente` INTEGER, `token` INTEGER, `iva_` INTEGER, `dataR` VARCHAR(50))  BEGIN
				DECLARE factura integer;
				DECLARE registros integer;
				DECLARE _total decimal(10.2);
				DECLARE subtotal decimal(10.2);
				DECLARE iva decimal(10.2);
				
				
				SET registros = (SELECT COUNT(*) FROM tb_detalhe_temp WHERE token_user=token);
				IF registros > 0 THEN 
				
				INSERT INTO tb_factura(usuario,cod_cliente,dataVenda) VALUES (token, cod_cliente,dataR);
				SET factura=LAST_INSERT_ID();
				INSERT INTO tb_detalhe_factura (nr_factura,cod_produto,description, quantidade,preco,subtotal_prod) SELECT (factura) as nr_factura,
				cod_produto,description, quantidade,preco,subtotal_prod FROM tb_detalhe_temp WHERE token_user=token;
				
				UPDATE tb_factura SET motivo=1 WHERE nr_factura=factura;
				SET subtotal=(SELECT SUM(quantidade * preco) FROM tb_detalhe_temp WHERE token_user= token);
				SET iva=(subtotal*iva_)/100;
				SET _total=iva+subtotal;
				UPDATE tb_factura SET subtotal_factura=subtotal WHERE nr_factura=factura;
				UPDATE tb_factura SET iva_factura=iva WHERE nr_factura=factura;
				UPDATE tb_factura SET total_factura=_total WHERE nr_factura=factura;
				
				DELETE FROM tb_detalhe_temp WHERE token_user=token;
				SELECT * FROM tb_factura WHERE nr_factura=factura;
				ELSE
				SELECT 0;
				END IF;

		END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `arquivo`
--

CREATE TABLE `arquivo` (
  `id` int(11) NOT NULL,
  `arquivo` varchar(200) NOT NULL,
  `data` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `arquivo`
--

INSERT INTO `arquivo` (`id`, `arquivo`, `data`) VALUES
(17, '3f05fb6f73026113bfa0ea668d3e5b6e.png', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `permissions` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `name`, `permissions`) VALUES
(1, 'standard', ''),
(2, 'Administrador', '{\"Admin\":1}');

-- --------------------------------------------------------

--
-- Table structure for table `tb_cliente`
--

CREATE TABLE `tb_cliente` (
  `idCliente` int(11) NOT NULL,
  `nuitCliente` int(11) DEFAULT NULL,
  `nomeCliente` varchar(60) DEFAULT NULL,
  `endereco` varchar(60) DEFAULT NULL,
  `contactoCliente` varchar(60) DEFAULT NULL,
  `iva` int(11) DEFAULT NULL,
  `usuario` int(11) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `tipo` varchar(50) DEFAULT NULL,
  `estado` varchar(50) DEFAULT NULL,
  `dataRegisto` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tb_cliente`
--

INSERT INTO `tb_cliente` (`idCliente`, `nuitCliente`, `nomeCliente`, `endereco`, `contactoCliente`, `iva`, `usuario`, `email`, `tipo`, `estado`, `dataRegisto`) VALUES
(8761, 350012325, 'João Manuel José', 'Matola', '841547004', 17, 11, 'joaojose@gmail.com', 'Temporario', 'Activo', '0000-00-00 00:00:00'),
(3194, 23434888, 'Lalgy Transportes', 'Matola', '841475001', 17, 11, 'tlalgy@gmail.com', 'Temporario', 'Activo', '0000-00-00 00:00:00'),
(3264, 11, 'Ultra Energy', 'Matola', '843699770', 17, 22, 'yorad.cassamo@ultraenergymz.com', 'Temporario', 'Activo', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tb_contrato`
--

CREATE TABLE `tb_contrato` (
  `cod_contrato` int(11) NOT NULL,
  `tipo_contrato` varchar(100) DEFAULT NULL,
  `usuario` int(11) DEFAULT NULL,
  `nr_cliente` int(11) DEFAULT NULL,
  `valor_contrato` decimal(10,2) DEFAULT NULL,
  `valor_prestacao` decimal(10,2) DEFAULT NULL,
  `data_assinatura` date DEFAULT NULL,
  `data_inicio` date DEFAULT NULL,
  `data_vencimento` date DEFAULT NULL,
  `duracao_contrato` int(11) DEFAULT NULL,
  `estado` varchar(100) DEFAULT NULL,
  `situacao` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tb_contrato`
--

INSERT INTO `tb_contrato` (`cod_contrato`, `tipo_contrato`, `usuario`, `nr_cliente`, `valor_contrato`, `valor_prestacao`, `data_assinatura`, `data_inicio`, `data_vencimento`, `duracao_contrato`, `estado`, `situacao`) VALUES
(6, 'Prestacao de Serviços', 11, 8761, '136000.00', '11000.00', '2021-06-01', '2021-06-02', '2022-01-01', 213, 'Em vigente', 'Novo'),
(7, 'Prestacao de Serviços', 11, 8761, '167880.00', '12000.00', '2021-06-02', '2021-06-03', '2021-12-31', 211, 'Vencido', 'Novo'),
(8, 'Prestacao de Serviços', 11, 8761, '23423.00', '2000.00', '2021-06-03', '2021-06-04', '2021-06-30', 26, 'Em vigente', 'Novo');

-- --------------------------------------------------------

--
-- Table structure for table `tb_controlo_recebimento_contrato`
--

CREATE TABLE `tb_controlo_recebimento_contrato` (
  `id` int(11) NOT NULL,
  `cod_contrato` int(11) DEFAULT NULL,
  `Janeiro` decimal(10,2) DEFAULT NULL,
  `Feverreiro` decimal(10,2) DEFAULT NULL,
  `Marco` decimal(10,2) DEFAULT NULL,
  `Abril` decimal(10,2) DEFAULT NULL,
  `Maio` decimal(10,2) DEFAULT NULL,
  `Junho` decimal(10,2) DEFAULT NULL,
  `Julho` decimal(10,2) DEFAULT NULL,
  `Agosto` decimal(10,2) DEFAULT NULL,
  `Setembro` decimal(10,2) DEFAULT NULL,
  `Outubro` decimal(10,2) DEFAULT NULL,
  `Novembro` decimal(10,2) DEFAULT NULL,
  `Dezembro` decimal(10,2) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tb_controlo_recebimento_contrato`
--

INSERT INTO `tb_controlo_recebimento_contrato` (`id`, `cod_contrato`, `Janeiro`, `Feverreiro`, `Marco`, `Abril`, `Maio`, `Junho`, `Julho`, `Agosto`, `Setembro`, `Outubro`, `Novembro`, `Dezembro`, `total`) VALUES
(5, 6, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '11000.00', '0.00', '0.00', '0.00', '0.00', '11000.00'),
(6, 7, '0.00', '12000.00', '0.00', '0.00', '0.00', '12000.00', '0.00', '0.00', '12000.00', '0.00', '0.00', '0.00', '36000.00'),
(7, 8, '0.00', '2000.00', '2000.00', '0.00', '2000.00', '2000.00', '2000.00', '0.00', '0.00', '0.00', '0.00', '0.00', '10000.00');

-- --------------------------------------------------------

--
-- Table structure for table `tb_cotacao`
--

CREATE TABLE `tb_cotacao` (
  `nr_factura` int(11) NOT NULL,
  `usuario` varchar(100) DEFAULT NULL,
  `cod_cliente` int(11) DEFAULT NULL,
  `motivo` varchar(300) DEFAULT NULL,
  `subtotal_factura` decimal(10,2) DEFAULT NULL,
  `iva_factura` decimal(10,2) DEFAULT NULL,
  `total_factura` decimal(10,2) DEFAULT NULL,
  `estado` int(11) DEFAULT '1',
  `dataVenda` varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tb_cotacao`
--

INSERT INTO `tb_cotacao` (`nr_factura`, `usuario`, `cod_cliente`, `motivo`, `subtotal_factura`, `iva_factura`, `total_factura`, `estado`, `dataVenda`) VALUES
(10, '11', 8761, '1', '158000.00', '26860.00', '184860.00', 1, '2021-06-01'),
(11, '11', 3194, '1', '1000.00', '170.00', '1170.00', 1, '2021-06-08'),
(12, '11', 3194, '1', '1800.00', '306.00', '2106.00', 1, '2021-06-08');

-- --------------------------------------------------------

--
-- Table structure for table `tb_dadosempresa`
--

CREATE TABLE `tb_dadosempresa` (
  `codigo` int(11) NOT NULL,
  `nome` varchar(60) DEFAULT NULL,
  `nuit` int(11) DEFAULT NULL,
  `nacional` varchar(60) DEFAULT NULL,
  `provincia` varchar(60) DEFAULT NULL,
  `cidade` varchar(60) DEFAULT NULL,
  `avenida` varchar(60) DEFAULT NULL,
  `nrCasa` varchar(60) DEFAULT NULL,
  `nrTelefone` varchar(100) DEFAULT NULL,
  `email` varchar(60) DEFAULT NULL,
  `webSite` varchar(60) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tb_dadosempresa`
--

INSERT INTO `tb_dadosempresa` (`codigo`, `nome`, `nuit`, `nacional`, `provincia`, `cidade`, `avenida`, `nrCasa`, `nrTelefone`, `email`, `webSite`) VALUES
(12342018, 'Multicast ServiÃ§os E.I', 139264199, 'Mocambique', 'Maputo', 'Maputo', 'R. da Copra', '27 - 1  Esq,  B Jardim', '(+258) 878552760 | (+258) 833211705', 'geral@multicastservicos.co.mz', 'https://www.multicastservicos.co.mz');

-- --------------------------------------------------------

--
-- Table structure for table `tb_detalheContrato_temp`
--

CREATE TABLE `tb_detalheContrato_temp` (
  `correlativo` int(11) NOT NULL,
  `codUsuario` int(11) DEFAULT NULL,
  `codCliente` int(11) DEFAULT NULL,
  `cod_produto` varchar(100) DEFAULT NULL,
  `description` varchar(200) DEFAULT NULL,
  `quantidade` int(11) DEFAULT NULL,
  `valor` decimal(10,2) DEFAULT NULL,
  `valor_subtotal` decimal(10,2) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tb_detalhe_contrato`
--

CREATE TABLE `tb_detalhe_contrato` (
  `correlativo` int(11) NOT NULL,
  `nr_contrato` int(11) DEFAULT NULL,
  `cod_produto` varchar(100) DEFAULT NULL,
  `description` varchar(200) DEFAULT NULL,
  `quantidade` int(11) DEFAULT NULL,
  `valor` decimal(10,2) DEFAULT NULL,
  `valor_subtotal` decimal(10,2) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tb_detalhe_contrato`
--

INSERT INTO `tb_detalhe_contrato` (`correlativo`, `nr_contrato`, `cod_produto`, `description`, `quantidade`, `valor`, `valor_subtotal`) VALUES
(9, 6, 'ms123', 'Criação de website', 1, '130000.00', '130000.00'),
(10, 6, 'ns11', 'Gestação de redes sociais', 4, '1500.00', '6000.00'),
(11, 7, 'mer1', 'Fornecimento de material informatico', 1, '12324.00', '12324.00'),
(12, 7, 'nsd22', 'Manunteção de sistema de gestão comercial', 1, '123412.00', '123412.00'),
(13, 7, 'gh123', 'Criação de sistema de gestão comercial', 1, '32144.00', '32144.00'),
(14, 8, 'mk', 'Montagem de rede', 1, '23423.00', '23423.00');

-- --------------------------------------------------------

--
-- Table structure for table `tb_detalhe_cotacao`
--

CREATE TABLE `tb_detalhe_cotacao` (
  `correlativo` int(11) NOT NULL,
  `nr_factura` int(11) DEFAULT NULL,
  `cod_servico` varchar(50) DEFAULT NULL,
  `description` varchar(300) DEFAULT NULL,
  `quantidade` int(11) DEFAULT NULL,
  `preco` decimal(10,2) DEFAULT NULL,
  `subtotal_prod` decimal(10,2) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tb_detalhe_cotacao`
--

INSERT INTO `tb_detalhe_cotacao` (`correlativo`, `nr_factura`, `cod_servico`, `description`, `quantidade`, `preco`, `subtotal_prod`) VALUES
(12, 10, 'ms12', 'Fornecimento de materia de escritório  e informático', 10, '15800.00', '158000.00'),
(13, 11, '1', 'Mouse wiifi', 2, '500.00', '1000.00'),
(14, 12, '1', 'Teclado wiifi', 3, '600.00', '1800.00');

-- --------------------------------------------------------

--
-- Table structure for table `tb_detalhe_factura`
--

CREATE TABLE `tb_detalhe_factura` (
  `correlativo` int(11) NOT NULL,
  `nr_factura` int(11) DEFAULT NULL,
  `cod_produto` varchar(100) DEFAULT NULL,
  `description` varchar(300) DEFAULT NULL,
  `quantidade` int(11) DEFAULT NULL,
  `preco` decimal(10,2) DEFAULT NULL,
  `subtotal_prod` decimal(10,2) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tb_detalhe_factura`
--

INSERT INTO `tb_detalhe_factura` (`correlativo`, `nr_factura`, `cod_produto`, `description`, `quantidade`, `preco`, `subtotal_prod`) VALUES
(15, 13, 'mcs12', 'Criação de um sistema de gestão comercial', 1, '180000.00', '180000.00'),
(16, 14, 'mkl12', 'sdfds dfg fdfg   gf bvjhgj nmhgjm njhg', 12, '12313.00', '147756.00');

-- --------------------------------------------------------

--
-- Table structure for table `tb_detalhe_temp`
--

CREATE TABLE `tb_detalhe_temp` (
  `correlativo` int(11) NOT NULL,
  `token_user` varchar(50) DEFAULT NULL,
  `codCliente` int(11) DEFAULT NULL,
  `cod_produto` varchar(100) DEFAULT NULL,
  `description` varchar(300) DEFAULT NULL,
  `quantidade` int(11) DEFAULT NULL,
  `preco` decimal(10,0) DEFAULT NULL,
  `subtotal_prod` decimal(10,0) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tb_detalhe_temp_cotacao`
--

CREATE TABLE `tb_detalhe_temp_cotacao` (
  `correlativo` int(11) NOT NULL,
  `token_user` varchar(50) DEFAULT NULL,
  `cod_Cliente` int(11) DEFAULT NULL,
  `cod_servico` varchar(50) DEFAULT NULL,
  `description` varchar(300) DEFAULT NULL,
  `quantidade` int(11) DEFAULT NULL,
  `preco` decimal(10,0) DEFAULT NULL,
  `subtotal_prod` decimal(10,0) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tb_factura`
--

CREATE TABLE `tb_factura` (
  `nr_factura` int(11) NOT NULL,
  `usuario` varchar(100) DEFAULT NULL,
  `cod_cliente` int(11) DEFAULT NULL,
  `motivo` varchar(300) DEFAULT NULL,
  `subtotal_factura` decimal(10,2) DEFAULT NULL,
  `iva_factura` decimal(10,2) DEFAULT NULL,
  `total_factura` decimal(10,2) DEFAULT NULL,
  `estado` int(11) DEFAULT '1',
  `dataVenda` varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tb_factura`
--

INSERT INTO `tb_factura` (`nr_factura`, `usuario`, `cod_cliente`, `motivo`, `subtotal_factura`, `iva_factura`, `total_factura`, `estado`, `dataVenda`) VALUES
(13, '11', 8761, '1', '180000.00', '30600.00', '210600.00', 1, '2021-06-01'),
(14, '11', 3194, '1', '147756.00', '25119.00', '172875.00', 1, '2021-06-08');

-- --------------------------------------------------------

--
-- Table structure for table `tb_mensalidade`
--

CREATE TABLE `tb_mensalidade` (
  `id` int(11) NOT NULL,
  `cod_contato` int(11) DEFAULT NULL,
  `nome_mes` varchar(100) DEFAULT NULL,
  `estado` varchar(100) DEFAULT NULL,
  `data_pagamento` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tb_mensalidade_tmp`
--

CREATE TABLE `tb_mensalidade_tmp` (
  `correlativo` int(11) NOT NULL,
  `cod_contrato` int(11) DEFAULT NULL,
  `nome_mes` varchar(100) DEFAULT NULL,
  `estado` varchar(100) DEFAULT NULL,
  `dataPagamento` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tb_pagamento_contrato`
--

CREATE TABLE `tb_pagamento_contrato` (
  `id` int(11) NOT NULL,
  `cod_contrato` int(11) DEFAULT NULL,
  `usuario` int(11) DEFAULT NULL,
  `valor_pago` decimal(10,2) DEFAULT NULL,
  `valor_iva` decimal(10,2) DEFAULT NULL,
  `valor_total` decimal(10,2) DEFAULT NULL,
  `mes_pago` varchar(50) DEFAULT NULL,
  `data_pagamento` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tb_pagamento_contrato`
--

INSERT INTO `tb_pagamento_contrato` (`id`, `cod_contrato`, `usuario`, `valor_pago`, `valor_iva`, `valor_total`, `mes_pago`, `data_pagamento`) VALUES
(1, 7, 11, '12000.00', '2040.00', '14040.00', 'Junho', '2021-06-03'),
(2, 6, 11, '11000.00', '1870.00', '12870.00', 'Janeiro', '2021-06-03'),
(3, 6, 11, '11000.00', '1870.00', '12870.00', 'Janeiro', '2021-06-03'),
(4, 6, 11, '11000.00', '1870.00', '12870.00', 'Fevereiro', '2021-06-03'),
(5, 6, 11, '11000.00', '1870.00', '12870.00', 'Março', '2021-06-03'),
(6, 6, 11, '11000.00', '1870.00', '12870.00', 'Abril', '2021-06-03'),
(7, 6, 11, '11000.00', '1870.00', '12870.00', 'Maio', '2021-06-03'),
(8, 6, 11, '11000.00', '1870.00', '12870.00', 'Junho', '2021-06-03'),
(9, 6, 11, '11000.00', '1870.00', '12870.00', 'Julho', '2021-06-03'),
(10, 6, 11, '11000.00', '1870.00', '12870.00', 'Agosto', '2021-06-03'),
(11, 6, 11, '11000.00', '1870.00', '12870.00', 'Setembro', '2021-06-03'),
(12, 6, 11, '11000.00', '1870.00', '12870.00', 'Outubro', '2021-06-03'),
(13, 6, 11, '11000.00', '1870.00', '12870.00', 'Novembro', '2021-06-03'),
(14, 6, 11, '11000.00', '1870.00', '12870.00', 'Dezembro', '2021-06-03'),
(15, 8, 11, '2000.00', '340.00', '2340.00', 'Novembro', '2021-06-03'),
(16, 8, 11, '2000.00', '340.00', '2340.00', 'Dezembro', '2021-06-03'),
(17, 8, 11, '2000.00', '340.00', '2340.00', 'Janeiro', '2021-06-03'),
(18, 8, 11, '2000.00', '340.00', '2340.00', 'Janeiro', '2021-06-03'),
(19, 8, 11, '2000.00', '340.00', '2340.00', 'Junho', '2021-06-03'),
(20, 8, 11, '2000.00', '340.00', '2340.00', 'Julho', '2021-06-03'),
(21, 8, 11, '2000.00', '340.00', '2340.00', 'Maio', '2021-06-03'),
(22, 7, 11, '12000.00', '2040.00', '14040.00', 'Junho', '2021-06-03'),
(23, 8, 11, '2000.00', '340.00', '2340.00', 'Fevereiro', '2021-06-03'),
(24, 7, 11, '12000.00', '2040.00', '14040.00', 'Fevereiro', '2021-06-05'),
(25, 7, 11, '12000.00', '2040.00', '14040.00', 'Setembro', '2021-06-05'),
(26, 6, 11, '11000.00', '1870.00', '12870.00', 'Agosto', '2021-06-05'),
(27, 8, 11, '2000.00', '340.00', '2340.00', 'Março', '2021-06-05');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `contact` varchar(50) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(64) NOT NULL,
  `salt` varchar(32) NOT NULL,
  `joined` datetime NOT NULL,
  `group` int(11) NOT NULL,
  `arquivo` varchar(200) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `contact`, `username`, `password`, `salt`, `joined`, `group`, `arquivo`) VALUES
(11, 'Gonçalves Senguele', '841547004', 'goncalvessenguele@gmail.com', '63a3bebdead91cb45966fd3c5c0e20dd56beb188dbea5bd41e25ff0a1cf10e58', '6sOWU`„&¹ú±¸§‚õ¹ÏŒ+Æ´Ü;ÓÍ–\"?¶Ò', '2021-05-23 15:38:42', 1, 'dadfd455e65c01d8bf209fcf77914b43.jpg'),
(22, 'Alvassone Jamisse', '827145275', 'alvassonejamisse@gmail.com', 'd2d0fa5c86d4dfeaa65333db024b1c84cabca2e95626977127d78189359bb730', '1®OôÏ&ùë“Óâþý¶¡JrH1 ªñNoix)K', '2021-05-23 14:22:16', 1, 'e84369e2e35fcaf964d1980125ab17c5.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users_session`
--

CREATE TABLE `users_session` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `hash` varchar(64) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users_session`
--

INSERT INTO `users_session` (`id`, `user_id`, `hash`) VALUES
(7, 22, '50c0be77bcff7ea510a6f6872567432f65246a729ade5385dbc59f6a0ef4a06b');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `arquivo`
--
ALTER TABLE `arquivo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_cliente`
--
ALTER TABLE `tb_cliente`
  ADD PRIMARY KEY (`idCliente`),
  ADD KEY `usuario` (`usuario`);

--
-- Indexes for table `tb_contrato`
--
ALTER TABLE `tb_contrato`
  ADD PRIMARY KEY (`cod_contrato`),
  ADD KEY `usuario` (`usuario`),
  ADD KEY `nr_cliente` (`nr_cliente`);

--
-- Indexes for table `tb_controlo_recebimento_contrato`
--
ALTER TABLE `tb_controlo_recebimento_contrato`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cod_contrato` (`cod_contrato`);

--
-- Indexes for table `tb_cotacao`
--
ALTER TABLE `tb_cotacao`
  ADD PRIMARY KEY (`nr_factura`);

--
-- Indexes for table `tb_detalheContrato_temp`
--
ALTER TABLE `tb_detalheContrato_temp`
  ADD PRIMARY KEY (`correlativo`),
  ADD KEY `codUsuario` (`codUsuario`),
  ADD KEY `codCliente` (`codCliente`);

--
-- Indexes for table `tb_detalhe_contrato`
--
ALTER TABLE `tb_detalhe_contrato`
  ADD PRIMARY KEY (`correlativo`),
  ADD KEY `nr_contrato` (`nr_contrato`);

--
-- Indexes for table `tb_detalhe_cotacao`
--
ALTER TABLE `tb_detalhe_cotacao`
  ADD PRIMARY KEY (`correlativo`),
  ADD KEY `nr_factura` (`nr_factura`);

--
-- Indexes for table `tb_detalhe_factura`
--
ALTER TABLE `tb_detalhe_factura`
  ADD PRIMARY KEY (`correlativo`),
  ADD KEY `nr_factura` (`nr_factura`);

--
-- Indexes for table `tb_detalhe_temp`
--
ALTER TABLE `tb_detalhe_temp`
  ADD PRIMARY KEY (`correlativo`);

--
-- Indexes for table `tb_detalhe_temp_cotacao`
--
ALTER TABLE `tb_detalhe_temp_cotacao`
  ADD PRIMARY KEY (`correlativo`);

--
-- Indexes for table `tb_factura`
--
ALTER TABLE `tb_factura`
  ADD PRIMARY KEY (`nr_factura`);

--
-- Indexes for table `tb_mensalidade`
--
ALTER TABLE `tb_mensalidade`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cod_contato` (`cod_contato`);

--
-- Indexes for table `tb_mensalidade_tmp`
--
ALTER TABLE `tb_mensalidade_tmp`
  ADD PRIMARY KEY (`correlativo`),
  ADD KEY `cod_contrato` (`cod_contrato`);

--
-- Indexes for table `tb_pagamento_contrato`
--
ALTER TABLE `tb_pagamento_contrato`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cod_contrato` (`cod_contrato`),
  ADD KEY `usuario` (`usuario`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_session`
--
ALTER TABLE `users_session`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `arquivo`
--
ALTER TABLE `arquivo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tb_contrato`
--
ALTER TABLE `tb_contrato`
  MODIFY `cod_contrato` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tb_controlo_recebimento_contrato`
--
ALTER TABLE `tb_controlo_recebimento_contrato`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tb_cotacao`
--
ALTER TABLE `tb_cotacao`
  MODIFY `nr_factura` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tb_detalheContrato_temp`
--
ALTER TABLE `tb_detalheContrato_temp`
  MODIFY `correlativo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `tb_detalhe_contrato`
--
ALTER TABLE `tb_detalhe_contrato`
  MODIFY `correlativo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `tb_detalhe_cotacao`
--
ALTER TABLE `tb_detalhe_cotacao`
  MODIFY `correlativo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `tb_detalhe_factura`
--
ALTER TABLE `tb_detalhe_factura`
  MODIFY `correlativo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `tb_detalhe_temp`
--
ALTER TABLE `tb_detalhe_temp`
  MODIFY `correlativo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `tb_detalhe_temp_cotacao`
--
ALTER TABLE `tb_detalhe_temp_cotacao`
  MODIFY `correlativo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `tb_factura`
--
ALTER TABLE `tb_factura`
  MODIFY `nr_factura` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `tb_mensalidade`
--
ALTER TABLE `tb_mensalidade`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `tb_mensalidade_tmp`
--
ALTER TABLE `tb_mensalidade_tmp`
  MODIFY `correlativo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `tb_pagamento_contrato`
--
ALTER TABLE `tb_pagamento_contrato`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `users_session`
--
ALTER TABLE `users_session`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
