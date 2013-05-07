/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *
 * @author jason
 */
public class Response
{
    private String question;
    private int questionNo;
    private String[] responses;

    public Response()
    {
        question=null;
        questionNo=-1;//done this because the first queston has a question number 0
        responses=null;

    }
    public void setQuestion(String question,int questionNo)
    {
        this.question=question;
        this.questionNo=questionNo;
    }
    public void setResponses(String[] responses)
    {
        this.responses=responses;
    }
    public String getQuestion()
    {
        return question;
    }
    public int getQuestionNo()
    {
        return questionNo;
    }
    public String getXml()
    {
        String xml="<query>";
        xml=xml+"<text>"+question+"</text>";
        xml=xml+"<questionNo>"+Integer.toString(questionNo)+"</questionNo>";
        xml=xml+"<answers size=\""+Integer.toString(responses.length)+"\">";
        int count=0;
        while(count<responses.length)
        {
            xml=xml+"<answer>";
            xml=xml+"<text>"+responses[count]+"</text>";
            xml=xml+"<rank>"+Integer.toString(count+1)+"</rank>";
            xml=xml+"</answer>";
            count++;
        }
        xml=xml+"</answers></query>";
        return xml;
    }

}
