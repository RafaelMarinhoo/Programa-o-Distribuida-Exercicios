package br.edu.ifpb.gugawag.so.sockets;

import java.io.DataInputStream;
import java.io.DataOutputStream;
import java.io.IOException;
import java.net.Socket;
import java.util.Scanner;

public class Cliente {

    public static void main(String[] args) throws IOException {
        System.out.println("== Cliente ==");

        // configurando o socket
        Socket socket = new Socket("192.168.1.4", 7001);
        // pegando uma referência do canal de saída do socket. Ao escrever nesse canal, está se enviando dados para o
        // servidor
        DataOutputStream dos = new DataOutputStream(socket.getOutputStream());
        // pegando uma referência do canal de entrada do socket. Ao ler deste canal, está se recebendo os dados
        // enviados pelo servidor
        DataInputStream dis = new DataInputStream(socket.getInputStream());

        while (true) {
            Scanner teclado = new Scanner(System.in);

            dos.writeUTF(teclado.nextLine());
            String mensagem = dis.readUTF();
            System.out.println("Servidor falou: " + mensagem);
        }

    }
}
