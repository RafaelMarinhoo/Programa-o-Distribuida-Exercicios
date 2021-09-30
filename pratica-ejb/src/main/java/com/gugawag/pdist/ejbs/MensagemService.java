package com.gugawag.pdist.ejbs;

import com.gugawag.pdist.model.Mensagem;

import javax.ejb.EJB;
import javax.ejb.Stateless;
import java.util.List;

@Stateless(name = "mensagemService")
public class MensagemService {

    @EJB
    private MensagemDAO mensagemDAO;

    public List<Mensagem> listar() {
        return mensagemDAO.listar();
    }

    public void inserir(long id, String texto) {
        Mensagem newMensagem = new Mensagem(id, texto);
        mensagemDAO.inserir(newMensagem);
    }

    public Mensagem pesquisarPorId(long id) {
        return mensagemDAO.pesquisarPorId(id);
    }

}