package br.edu.ifpb.gugawag.so.sockets;

import java.io.DataInputStream;
import java.io.DataOutputStream;
import java.io.File;
import java.io.IOException;
import java.net.ServerSocket;
import java.net.Socket;
import java.util.ArrayList;
import java.util.List;
import java.util.StringTokenizer;

public class Servidor {

    public static void main(String[] args) throws IOException {
        System.out.println("== Servidor ==");

        // Configurando o socket
        ServerSocket serverSocket = new ServerSocket(7001);
        Socket socket = serverSocket.accept();

        // Pegando uma referência do canal de saída do ‘socket’. Ao escrever nesse canal, está se enviando dados para o
        // servidor
        DataOutputStream dos = new DataOutputStream(socket.getOutputStream());
        // Pegando uma referência do canal de entrada do ‘socket’. Ao ler deste canal, está se recebendo os dados
        // enviados pelo servidor
        DataInputStream dis = new DataInputStream(socket.getInputStream());

        // laço infinito do servidor
        while (true) {
            System.out.println("Cliente: " + socket.getInetAddress());
            List<String> resposta = new ArrayList<String>();
            String mensagem = dis.readUTF();
            System.out.println(mensagem);


            if(mensagem.startsWith("readdir")){
                StringTokenizer strToken = new StringTokenizer(mensagem, " ");
                strToken.nextToken();
                File pasta = new File(strToken.nextToken());
                File[] arquivos = pasta.listFiles();

                for (File arquivo : arquivos){
                    resposta.add(arquivo.getName());
                }
                dos.writeUTF(resposta.toString());

            }else if(mensagem.startsWith("rename")){
                StringTokenizer strToken = new StringTokenizer(mensagem, " ");
                strToken.nextToken();
                File pasta = new File(strToken.nextToken());
                pasta.renameTo(new File(strToken.nextToken()));
                dos.writeUTF("Arquivo renomeado.");

            }else if(mensagem.startsWith("create")){
                StringTokenizer strToken = new StringTokenizer(mensagem, " ");
                strToken.nextToken();
                File pasta = new File(strToken.nextToken());
                pasta.mkdirs();
                dos.writeUTF("Arquivo criado.");

            }else if(mensagem.startsWith("remove")){
                StringTokenizer strToken = new StringTokenizer(mensagem, " ");
                strToken.nextToken();
                File pasta = new File(strToken.nextToken());
                pasta.delete();
                dos.writeUTF("Arquivo removido.");

            } else {
                dos.writeUTF("Li sua mensagem: " + mensagem);
            }

        }
        /*
         * Observe o while acima. Perceba que primeiro se lê a mensagem vinda do cliente (linha 29, depois se escreve
         * (linha 32) no canal de saída do socket. Isso ocorre da forma inversa do que ocorre no while do Cliente2,
         * pois, de outra forma, daria deadlock (se ambos quiserem ler da entrada ao mesmo tempo, por exemplo,
         * ninguém evoluiria, já que todos estariam aguardando.
         */
    }
}