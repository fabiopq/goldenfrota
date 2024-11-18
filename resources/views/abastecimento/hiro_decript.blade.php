<?php




if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
    
  
$file = $_FILES['file']['tmp_name'];
    
   
$outputFileName = 'output.txt';
    
    

 
$xorValue = 106;

    

   
if (is_uploaded_file($file)) {
        
    
$inputContent = file_get_contents($file);
        
       

     

 
$outputContent = '';

        

       


 
// Realiza o XOR em cada byte do conteúdo
        
      

   
for ($i = 0; $i < strlen($inputContent); $i++) {
            
        

          

       

    
$outputContent .= chr(ord($inputContent[$i]) ^ $xorValue);
        }

        
        }

        

        }

    

        }

// Salva o novo arquivo
        
    

   
file_put_contents($outputFileName, $outputContent);
        
     

 
echo "Arquivo processado com sucesso. <a href='$outputFileName' download>Clique aqui para baixar</a>";
    } 
    }
else {
        
        

    
echo "Erro ao carregar o arquivo.";
    }
} 
    }
} else

    }
}

  
else {
    ?>
<!DOCTYPE html>
<html lang=<!DOCTYPE html>
<h <!DOCTYPE html>


    <!DOCTYPE html>

    <!DOCTYPE h <!DOCT < "pt-BR">

    <head>
        <meta charset=<head>
        <meta cha <head>
        < <head>


            <head>


                <he "UTF-8">
                    <title>Processador de Arquivos XOR</title>
            </head>

    <body>
        <h1>Selecione um arquivo para processar</h1>
        <form action=<title>Processador de Arquivos XOR</title>
            </head>

            <body>
                <h1>Selecione um arquivo para processar</h1>
                <form actio <title>Processador de Arquivos XOR</title>
                    </head>

                    <body>
                        <h1>Selecione um arquivo para processar</h1>
                        <fo <title>Processador de Arquivos XOR</title>
                            </head>

                            <body>
                                <h1>Selecione um arquivo para processar</h1>

                                <title>Processador de Arquivos XOR</title>
                                </head>

                                <body>
                                    <h1>Selecione um arquivo para processar</ <title>Processador de Arquivos XOR</title>
                                        </head>

                                        <body>
                                            <h1>Selecione um arquivo para process

                                                <title>Processador de Arquivos XOR</title>
                                                </head>

                                                <body>
                                                    <h1>Selecione um arquivo para pr

                                                        <title>Processador de Arquivos XOR</title>
                                                        </head>

                                                        <body>
                                                            <h1>Selecione um arquivo pa

                                                                <title>Processador de Arquivos XOR</title>
                                                                </head>

                                                                <body>
                                                                    <h1>Selecione um arqu

                                                                        <title>Processador de Arquivos XOR</title>
                                                                        </head>

                                                                        <body>
                                                                            <h1>Selecione

                                                                                <title>Processador de Arquivos XOR
                                                                                </title>
                                                                                </head>

                                                                                <body>
                                                                                    <h1>Selecio

                                                                                        <title>Processador de Arquivos
                                                                                            XOR</title>
                                                                                        </head>

                                                                                        <body>
                                                                                            <h1>Sel

                                                                                                <title>Processador de
                                                                                                    Arquivos XOR</title>
                                                                                                </head>

                                                                                                <body>
                                                                                                    <h1 <title>
                                                                                                        Processador de
                                                                                                        Arquivos XOR
                                                                                                        </title>
                                                                                                        </head>

                                                                                                        <body>


                                                                                                            <title>
                                                                                                                Processador
                                                                                                                de
                                                                                                                Arquivos
                                                                                                                XOR
                                                                                                            </title>
                                                                                                            </head>

                                                                                                            <body>


                                                                                                                <title>
                                                                                                                    Processador
                                                                                                                    de
                                                                                                                    Arquivos
                                                                                                                    XOR
                                                                                                                </title>
                                                                                                                </head>
                                                                                                                <b
                                                                                                                    <title>Processador
                                                                                                                    de
                                                                                                                    Arquivos
                                                                                                                    XOR
                                                                                                                    </title>
                                                                                                                    <
                                                                                                                        <title>
                                                                                                                        Processador
                                                                                                                        de
                                                                                                                        Arquivos
                                                                                                                        XOR
                                                                                                                        </title>


                                                                                                                        <title>
                                                                                                                            Processador
                                                                                                                            de
                                                                                                                            Arquivos
                                                                                                                            XOR
                                                                                                                            </titl
                                                                                                                                <title>
                                                                                                                            Processador
                                                                                                                            de
                                                                                                                            Arquivos
                                                                                                                            XOR
                                                                                                                    </
                                                                                                                        <title>
                                                                                                                    Processador
                                                                                                                    de
                                                                                                                    Arquivos

                                                                                                                    <title>
                                                                                                                        Processador
                                                                                                                        de
                                                                                                                        Arq

                                                                                                                        <title>
                                                                                                                            Processador

                                                                                                                            <title>
                                                                                                                                Proce

                                                                                                                                <title>
                                                                                                                                    P

                                                                                                                                    <ti ""
                                                                                                                                        method="post"
                                                                                                                                        enctype="multipart/form-data">
                                                                                                                                        <input
                                                                                                                                            type=<in "file"
                                                                                                                                            name="file"
                                                                                                                                            required>
                                                                                                                                        <button
                                                                                                                                            type=<button
                                                                                                                                            typ
                                                                                                                                            <but "submit">Processar</button>
                </form>
            </body>

</html>

</form>
</body>

</html>


</form>
</body>
</ht </form>
</body>


</form>
</body>

</form>
</bo </form>


</form <?php
}

}

?>
